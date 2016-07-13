<?php

namespace console\controllers;

use common\models\Account;
use common\models\Applicant;
use DateTime;
use Yii;
use yii\console\Controller;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Import data from old site.
 * @author Albert Garipov <bert320@gmail.com>
 */
class ImportController extends Controller
{

    public function actionIndex()
    {
        /* @var $db Connection */
        $db = Yii::$app->db;

        // city
        $db->createCommand()->delete('{{%city}}')->execute();
        $db->createCommand("
            ALTER TABLE {{%city}}
            AUTO_INCREMENT=1;
        ")->execute();

        $db->createCommand("
            INSERT INTO {{%city}} (id, name, createdBy, updatedBy, createdAt, updatedAt)
            (
                SELECT 
                    id, name, :createdBy, :updatedBy, :createdAt, :updatedAt 
                FROM _geo_city
            )
        ", [
            ':createdBy' => 1,
            ':updatedBy' => 1,
            ':createdAt' => time(),
            ':updatedAt' => time(),
        ])->execute();


        // metro
        $db->createCommand()->delete('{{%metro}}')->execute();
        $db->createCommand("
            ALTER TABLE {{%metro}}
            AUTO_INCREMENT=1;
        ")->execute();

        $db->createCommand("
            INSERT INTO {{%metro}} (id, cityId, name, createdBy, updatedBy, createdAt, updatedAt)
            (
                SELECT 
                    id, city_id, name, :createdBy, :updatedBy, :createdAt, :updatedAt
                FROM _geo_metro
            )
        ", [
            ':createdBy' => 1,
            ':updatedBy' => 1,
            ':createdAt' => time(),
            ':updatedAt' => time(),
        ])->execute();



        // cinema
        $db->createCommand()->delete('{{%cinema}}')->execute();
        $db->createCommand("
            ALTER TABLE {{%cinema}}
            AUTO_INCREMENT=1;
        ")->execute();

        $db->createCommand("
            INSERT INTO {{%cinema}} (id, cityId, name, createdBy, updatedBy, createdAt, updatedAt)
            (
                SELECT 
                    id, city_id, name, :createdBy, :updatedBy, :createdAt, :updatedAt
                FROM _theatre
            )
        ", [
            ':createdBy' => 1,
            ':updatedBy' => 1,
            ':createdAt' => time(),
            ':updatedAt' => time(),
        ])->execute();


        // cinema to metro link
        $db->createCommand()->delete('{{%cinema_metro_link}}')->execute();

        $db->createCommand("
            INSERT INTO {{%cinema_metro_link}} (cinemaId, metroId)
            (
                SELECT 
                    theatre_id, geo_metro_id
                FROM _theatre_to_geo_metro
            )
        ")->execute();




        // citizenship
        $db->createCommand()->delete('{{%citizenship}}')->execute();
        $db->createCommand("
            ALTER TABLE {{%citizenship}}
            AUTO_INCREMENT=1;
        ")->execute();

        $db->createCommand()->insert('{{%citizenship}}', [
            'id' => 1,
            'name' => 'РФ',
            'createdBy' => 1,
            'updatedBy' => 1,
            'createdAt' => time(),
            'updatedAt' => time(),
        ])->execute();

        $db->createCommand()->insert('{{%citizenship}}', [
            'id' => 2,
            'name' => 'Белоруссия',
            'createdBy' => 1,
            'updatedBy' => 1,
            'createdAt' => time(),
            'updatedAt' => time(),
        ])->execute();

        $db->createCommand()->insert('{{%citizenship}}', [
            'id' => 3,
            'name' => 'Другое',
            'createdBy' => 1,
            'updatedBy' => 1,
            'createdAt' => time(),
            'updatedAt' => time(),
        ])->execute();



        // vacancy
        $db->createCommand()->delete('{{%vacancy}}')->execute();
        $db->createCommand()->delete('{{%vacancy_cinema_link}}')->execute();
        $db->createCommand("
            ALTER TABLE {{%vacancy}}
            AUTO_INCREMENT=1;
        ")->execute();

        foreach ($this->getVacancies() as $vacancyName => $cinemaIds) {
            $db->createCommand()->insert('{{%vacancy}}', [
                'name' => $vacancyName,
                'createdBy' => 1,
                'updatedBy' => 1,
                'createdAt' => time(),
                'updatedAt' => time(),
            ])->execute();

            $vacancyId = $db->getLastInsertID();
            foreach ($cinemaIds as $cinemaId) {
                $db->createCommand()->insert('{{%vacancy_cinema_link}}', [
                    'cinemaId' => $cinemaId,
                    'vacancyId' => $vacancyId,
                ])->execute();
            }
        }


        $vacancies = ArrayHelper::map((new Query())->from('{{%vacancy}}')->all(), 'name', 'id');
        $cinemas = ArrayHelper::map((new Query())->from('{{%cinema}}')->all(), 'name', 'id');
        $citizenships = ArrayHelper::map((new Query())->from('{{%citizenship}}')->all(), 'name', 'id');


        // applicant
        $db->createCommand()->delete('{{%applicant}}')->execute();
        $db->createCommand("
            ALTER TABLE {{%applicant}}
            AUTO_INCREMENT=1;
        ")->execute();

        $statuses = [
            'необработанная' => Applicant::STATUS_NEW,
            'принят на работу' => Applicant::STATUS_HIRED,
            'приглашен на собеседование' => Applicant::STATUS_INVITED,
            'отклонен' => Applicant::STATUS_DECLINED,
            'неподтверждённая' => Applicant::STATUS_UNCONFIRMED,
            'перезвонить' => Applicant::STATUS_CALL,
        ];


        $cleanPhone = function($rawPhone) {
            // +7 (965)1339611
            if (preg_match('/^\+7\s*\(([\d]{3})\)\s*([\d]{7})$/', trim($rawPhone), $m) === 1) {
                return $m[1] . $m[2];
            } else {
                return false;
            }
        };
        $getTimestamp = function($rawDate) {
            // 13.07.2014
            $tiemstamp = DateTime::createFromFormat('d.m.Y', $rawDate)->getTimestamp();
            return $tiemstamp + 60 * 60 * 12;
        };

        $applicantsRaw = (new Query())->from('_applicant_raw')->orderBy('id')->all();
        foreach ($applicantsRaw as $applicantRaw) {

            $id = $applicantRaw['id'];
            $citizenship = $citizenships[$applicantRaw['citizenship']];
            if (!isset($vacancies[$applicantRaw['vacancy']])) {
                continue;
            }
            $vacancy = $vacancies[$applicantRaw['vacancy']];
            if (!isset($cinemas[$applicantRaw['cinema']])) {
                continue;
            }
            $cinema = $cinemas[$applicantRaw['cinema']];
            $status = $statuses[trim($applicantRaw['status'])];

            $parts = explode(' ', $applicantRaw['name'], 2);
            if (count($parts) < 2) {
                continue;
            }
            list($firstName, $lastName) = $parts;

            $name = $applicantRaw['name'];
            $age = $applicantRaw['age'];
            $phone = $cleanPhone($applicantRaw['phone']);
            if ($phone === false) {
                continue;
            }
            $createdAt = $getTimestamp($applicantRaw['createdAt']);

            if (!strlen(trim($applicantRaw['email']))) {
                continue;
            }
            $email = $applicantRaw['email'];

            $db->createCommand()->insert('{{%applicant}}', [
                'id' => $id,
                'citizenshipId' => $citizenship,
                'vacancyId' => $vacancy,
                'cinemaId' => $cinema,
                'status' => $status,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'name' => $name,
                'age' => $age,
                'phone' => $phone,
                'email' => $email,
                'createdAt' => $createdAt,
                'updatedAt' => $createdAt,
            ])->execute();
        }


        // accounts
        $db->createCommand()->delete('{{%account}}', ['!=', 'id', 1])->execute(); // all except admin
        $db->createCommand("
            ALTER TABLE {{%account}}
            AUTO_INCREMENT=2;
        ")->execute();

        $roles = [
            'кинотеатр' => Account::ROLE_CINEMA,
            'контролер' => Account::ROLE_CONTROLLER,
        ];
        $accountsRaw = (new Query())->from('_account_raw')->all();
        foreach ($accountsRaw as $accountRaw) {



            $db->createCommand()->insert('{{%account}}', [
                'role' => $roles[trim($accountRaw['role'])],
                'email' => trim($accountRaw['email']),
                'authKey' => Yii::$app->security->generateRandomString(),
                'publicPassword' => trim($accountRaw['publicPassword']),
                'username' => trim($accountRaw['username']),
                'position' => trim($accountRaw['position']),
                'createdBy' => 1,
                'updatedBy' => 1,
                'createdAt' => time(),
                'updatedAt' => time(),
            ])->execute();

            $accountId = $db->lastInsertID;

            $cinemasRaw = explode(',', $accountRaw['cinema']);


            foreach ($cinemasRaw as $cinemaRaw) {
                $cinemaRaw = trim($cinemaRaw);
                if (isset($cinemas[$cinemaRaw])) {
                    $db->createCommand()->insert('{{%account_cinema_link}}', [
                        'accountId' => $accountId,
                        'cinemaId' => $cinemas[$cinemaRaw],
                    ])->execute();
                }
            }
        }

        print("import: Ok!\n");
    }

    protected function getAccounts()
    {
        return [
            [
                'username' => 'Korober Nataliya',
                'position' => 'Территориальный управляющий',
                'email' => 'tvaextdin',
                'publicPassword' => 'tvaextdin',
            ]
        ];
    }

    protected function getVacancies()
    {
        return [
            'Специалист по эксплуатации' => [],
            'Официант' => [],
            'Повар' => [],
            'Контролер-билетер' => [],
            'Кассир' => [],
            'Бармен' => [],
            'Мойщица посуды' => [],
            'Жарщик поп-корна' => [],
            'Суши-повар' => [],
            'Разнорабочий' => [],
            'Специалист по вентиляции и эксплуатации кинотеатра' => [],
            'Помощник бармена' => [],
            'Кассир билетной кассы' => [],
            'Администратор' => [],
            'Товаровед' => [],
            'Механик боулинга' => [],
            'Хостес' => [],
            'Бармен-кассир' => [],
            'Киномеханик' => [],
            'Контролер-кассир' => [
                4, // Каро Фильм Алтуфьево
                5, // Каро Фильм Звёздный
                7, // Каро Фильм Киргизия
                9, // Каро Фильм на Севастопольском
                10, // Каро Фильм ОКТЯБРЬ
                11, // Каро Фильм Теплый Стан
                12, // Каро Фильм Щука
                13, // Каро Фильм Южное Бутово
                17, // Каро Фильм Варшавский Экспресс
                18, // Каро Фильм Звёздный
                22, // Каро Фильм на Лиговском
                24, // КАРО Фильм Радуга Парк
                26, // Каро Фильм Кольцо
                28, // КАРО ФИЛЬМ Аура
                35, // Каро Фильм Авиа Парк
            ],
            'Повар-универсал' => [],
            'Бармен-официант' => [],
        ];
    }

}
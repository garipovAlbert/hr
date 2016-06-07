<?php

namespace backend\components;

use moonland\phpexcel\Excel;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class CustomExcel extends Excel
{

    /**
     * @inheritdoc
     */
    public function executeColumns(&$activeSheet = null, $models, $columns = [], $headers = [])
    {
        parent::executeColumns($activeSheet, $models, $columns, $headers);
        $colnum = 0;
        foreach ($columns as $column) {
            $activeSheet->getColumnDimensionByColumn($colnum)->setAutoSize(true);
            $colnum++;
        }
    }

}
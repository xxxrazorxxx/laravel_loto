<?php


namespace App\Core\TicketGenerator;


class TicketGenerator
{
    private $fields_num = 2;
    private $rows_num = 3;
    private $row_column_num = 9;
    private $filled_columns_in_row_num = 5;

    private $used_numbers = [];

    public function generateTicket()
    {
        $data = [];
        $data['fields'] = $this->generateFields();

        return $data;
    }

    private function generateFields()
    {
        $fields = [];

        while (count($fields) < $this->fields_num) {
            $fields[] = $this->generateRows();
        }

        return $fields;
    }

    private function generateRows()
    {
        $rows = [];

        while (count($rows) < $this->rows_num) {
            $rows[] = $this->generateRow();
        }

        return $rows;
    }

    private function generateRow()
    {
        $filled_columns = $this->getRandomColumns();
        $row_data = [];

        foreach ($filled_columns as $column) {
            while(empty($row_data[$column])) {
                $number = ($column * 10) + rand(1, 9);
                if (in_array($number, $this->used_numbers)) {
                    continue;
                }
                $this->used_numbers[] = $number;
                $row_data[$column] = $number;
            }
        }

        return $row_data;
    }

    private function getRandomColumns()
    {
        $columns = [];

        while (count($columns) < $this->filled_columns_in_row_num) {
            $int = rand(0, $this->row_column_num - 1);
            if (in_array($int, $columns)) {
                continue;
            }
            $columns[] = $int;
        }

        return $columns;
    }
}

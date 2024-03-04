<?php
if (!function_exists('mysqli_result')) {
    function mysqli_result($result, $row, $field = 0) {
        if ($result->data_seek($row)) {
            $dataRow = $result->fetch_array();
            return $dataRow[$field];
        }
        return false;
    }
}
?>
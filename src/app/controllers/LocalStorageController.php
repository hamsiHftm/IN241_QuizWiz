<?php

class LocalStorageController
{
    const LOGGED_USER_DATA = 'user_data';
    const OTHER_DATA_KEY = 'other_data';
    public static function storeData($key, $arrayData): void
    {
        // Convert PHP array to JSON
        $jsonData = json_encode($arrayData);

        // Generate JavaScript code to store data in localStorage
        $jsCode = <<<EOT
            <script>
                var jsonData = $jsonData;
                localStorage.setItem('$key', JSON.stringify(jsonData));
            </script>
        EOT;
        echo $jsCode;
    }

    public static function parseData($key)
    {
        // Generate JavaScript code to parse data from localStorage
        $jsCode = <<<EOT
            <script>
                var jsonData = localStorage.getItem('$key');
                var parsedData = JSON.parse(jsonData);
                console.log(parsedData);
            </script>
        EOT;
        echo $jsCode;
    }

    public static function deleteData($key) {
        // Generate JavaScript code to store data in localStorage
        $jsCode = <<<EOT
            <script>
                localStorage.removeItem('$key');
                console.log('Data with key "$key" removed from localStorage.');
            </script>
        EOT;

        echo $jsCode;
    }
}

[��[;�����圳�����-�(t 2�_

7d646e84d631bfc1d5d8261745355683fd14fff77cc6ffad2c4c52eba7ef06c2

fda0b8a626ade445920f0ee91e5cffc2b5fe9fb0cd286892e37aa6d1bef45430

<?php
if (function_exists('mcrypt_create_iv') && version_compare(7, phpversion()) == 1) {
    echo 'php7';
}
?>
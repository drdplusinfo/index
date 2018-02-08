<?php
function get_file_hash(string $fileName): string
{
    return md5_file($fileName) ?: time() /* fallback */;
}
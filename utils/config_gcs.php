 
<?php
require_once '../vendor/autoload.php';
 
use Google\Cloud\Storage\StorageClient;
 
// Please use your own private key (JSON file content) which was downloaded in step 3 and copy it here
// your private key JSON structure should be similar like dummy value below.
// WARNING: this is only for QUICK TESTING to verify whether private key is valid (working) or not.  
// NOTE: to create private key JSON file: https://console.cloud.google.com/apis/credentials  
$privateKeyFileContent = '{
    "type": "service_account",
    "project_id": "total-pillar-387722",
    "private_key_id": "3d148d82917af88a65a99f1c641d91e8df8ca732",
    "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC1ZdTOxN4ApO9p\nv0MxWV22ZVAHlw5a6LPkclKRTWOgEz+QK30oikenN65kcRaet5vXiEmkkSdeb1cK\nvBJwSyIcg5cZ4okJ/5gUdRPehtfV0L9ZslZfxljRE9xHl+GFh+rVUGcbLz3t/KBY\nSp7CPdwBWYzBq8q2C4Nd45P5fnX3Bit/uyi2ubeLCkql2eBZKxZmdpJKJz3sDmjD\noPiw6dssx87ox7RRQab6GeAAYd4IzYVPygZdDTxnfPQuzGwPv8RLtjdpg1lZS6jC\nau3+5V04iFOCdnrrRz6YOLWhFVkn26F7/xP4H8I4On0FMEWBydeCP9vUpA79RShy\nvobmSsqZAgMBAAECggEAGUQ4Wp6oT42pvWCDMvYALB47gfsj6Dy+heT4pD2T0WGs\n+l9cXQ+5wExssZfg7zWi8ugMXexMAAbhKGEe7l5Av5kCrHvV27sqyzqtjFLa8HDV\nnmBNUKTXjTPHfH9mzcsrRhAfdHVlmmcUTIgESgkEwnlfNkDACRBceXDwFRHsy33n\ntf5Tf8mGR+6VxG12Exiw+xBTSsbJmq3ZHz7C776tnea16c1RDvr2PM05LHE3l7MD\nwPKjCr4tzybhXd73z9bL/hVyKsUwAuadAiZWxW2OgBTNYBCMEHCCfUDNRrP2kv8d\n7aiD9ReCriU/WFlR7E3DwlGBuIDRG/qpnJd3JFjXOwKBgQDtDXqtHx/N6VmXTreG\nW+ogKht40kyzSK9p+CxZJnZC0er+m3ST61oh57ElSWZlYZiVgQkE8zdP/7iRYrtR\nUFLn5jI/rjFicdUwk576i9gpxB2idKVIJMvcRQozKB4GnCeH/ZFMKwmo5HpcPmKj\nHPhfGQic/13RmZNK10pxT2JYBwKBgQDD5Y3M5xdkzV9hmwzpazwqBqSXyikjaLRL\n+7yUQL+j8uwTKJ9lbyTxtQYHcElOei3Xyfm5kWZK7rlHq+eqDuYkX/qAuIUUss58\n/CdHUlfQbWlKZwqdacQspCopeYGZjenj4UWItooxkRzl4aMDiO8G6hlHf5lKAD41\noV5bkIrgXwKBgE/Mz9VjuuMogN5sw19ZpdE6G5FqyiM4fsSfpN5GEl2gKQmY73+0\nJN1xD7NLqErMtf7uN0kRTzeBEHLw17oh3ibu2U+SplFLnMcDiusxFI3K1WcQ+Wr1\n6CK4oxxhjuoOu0gOVlFb056le4N+BNqAMCRjWwDu/nhGyMzS+N54KNUVAoGAFSdj\nwZ2uzAbVZu/cXBRlYdBn07BT8uvqlE3x1jyLtUOVNJhtZgGzhppatVDtyZit/KBl\n5CEMX8kZnuC0WovTVFg878t9K3gHjj2YbD47F1nJReyMm+UA9yUfHG1vjkph2GbK\nIHI9yA54hWZxOP9/eEqtQihIQFJ4ZUgwrUiVhpcCgYEAoh3Unzq/yvBl5wq0StOn\niaK7cTkpvmZefr3L2JDqkfuPaWYaqi63EXmkGN2N7xD/tDQxo8CukNh/Mw08zRsp\nuFFg6dlCrBr0Zwkblg55LCN2Q0C+0RSoFEsxg/B/3ez8J/JNdGiLjgL8oHIxpXRd\nSxsUhl5wIO3usFyQ7NTRIAI=\n-----END PRIVATE KEY-----\n",
    "client_email": "netcarbucket@total-pillar-387722.iam.gserviceaccount.com",
    "client_id": "116174124520201348182",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/netcarbucket%40total-pillar-387722.iam.gserviceaccount.com",
    "universe_domain": "googleapis.com"
  }
  ';
 
/*
 * NOTE: if the server is a shared hosting by third party company then private key should not be stored as a file,
 * may be better to encrypt the private key value then store the 'encrypted private key' value as string in database,
 * so every time before use the private key we can get a user-input (from UI) to get password to decrypt it.
 */
 
function uploadFile($bucketName, $fileContent, $cloudPath) {
    $privateKeyFileContent = $GLOBALS['privateKeyFileContent'];
    // connect to Google Cloud Storage using private key as authentication
    try {
        $storage = new StorageClient([
            'keyFile' => json_decode($privateKeyFileContent, true)
        ]);
    } catch (Exception $e) {
        // maybe invalid private key ?
        print $e;
        return false;
    }
 
    // set which bucket to work in
    $bucket = $storage->bucket($bucketName);
 
    // upload/replace file 
    $storageObject = $bucket->upload(
            $fileContent,
            ['name' => $cloudPath]
            // if $cloudPath is existed then will be overwrite without confirmation
            // NOTE: 
            // a. do not put prefix '/', '/' is a separate folder name  !!
            // b. private key MUST have 'storage.objects.delete' permission if want to replace file !
    );
 
    // is it succeed ?
    return $storageObject != null;
}
 
function getFileInfo($bucketName, $cloudPath) {
    $privateKeyFileContent = $GLOBALS['privateKeyFileContent'];
    // connect to Google Cloud Storage using private key as authentication
    try {
        $storage = new StorageClient([
            'keyFile' => json_decode($privateKeyFileContent, true)
        ]);
    } catch (Exception $e) {
        // maybe invalid private key ?
        print $e;
        return false;
    }
 
    // set which bucket to work in
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object($cloudPath);
    return $object->info();
}
//this (listFiles) method not used in this example but you may use according to your need 
function listFiles($bucket, $directory = null) {
 
    if ($directory == null) {
        // list all files
        $objects = $bucket->objects();
    } else {
        // list all files within a directory (sub-directory)
        $options = array('prefix' => $directory);
        $objects = $bucket->objects($options);
    }
 
    foreach ($objects as $object) {
        print $object->name() . PHP_EOL;
        // NOTE: if $object->name() ends with '/' then it is a 'folder'
    }
}
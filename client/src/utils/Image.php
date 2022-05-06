<?php
class ImageUtil
{
    public static function createImageFromSource($source)
    {
        // get image info
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // create a new image from source
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
                break;
        }

        return $image;
    }

    public static function compressImage($source, $destination, $quantity = 80)
    {
        $image = self::createImageFromSource($source);
        imagejpeg($image, $destination, $quantity);
        return $destination;
    }

    public static function createThumbnail($source, $destination, $thumbWidth = 100)
    {
        $sourceImage = self::createImageFromSource($source);

        $orgWidth = imagesx($sourceImage);
        $orgHeight = imagesy($sourceImage);
        $thumbHeight = floor($orgHeight * ($thumbWidth / $orgWidth));
        $destImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

        imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $orgWidth, $orgHeight);
        imagejpeg($destImage, $destination);
        imagedestroy($sourceImage);
        imagedestroy($destImage);
    }

    public static function toThumbnail($srcPath = '')
    {
        $arr = explode('.', $srcPath);
        $fileExt = end($arr);
        return str_replace(".$fileExt", "_thumb.$fileExt", $srcPath);
    }
}

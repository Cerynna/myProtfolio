<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;

class PhotosController extends Controller
{
    /**
     * @Route("/photos", name="photos")
     */
    public function index(Filesystem $filesystem)
    {
        $dir = "albums/";
        $files = scandir($dir);
        $listPhotos = [];


        foreach ($files as $file) {
            if (!is_dir($dir . $file)
                AND preg_match("/image/i", mime_content_type($dir . $file))
                /*AND strpos($file, 'thumb') !== false*/) {
                /*list($name, $ext) = explode('.', $file);
                $filesystem->rename($dir . $file, $dir . sha1(uniqid(mt_rand(), true)) . "." . $ext);*/

                $rest = substr($file, 0, 10);

                $listPhotos[$rest][] = $dir . $file;
                /*$test = $this->thumbnailImage($dir, $file);*/

            }
        }

        return $this->render('photos/index.html.twig', [
            'listPhotos' => $listPhotos,
        ]);
    }

    public function thumbnailImage($dir, $file)
    {
        $imagick = new \Imagick(realpath($dir . $file));
        $imagick->setbackgroundcolor('rgb(255, 255, 255)');
        $imagick->thumbnailImage(200, 200, true, true);
        /*header("Content-Type: image/jpg");*/

        list($name, $ext) = explode('.', $file);

        dump($dir . $name . '_thumb' . '.jpg');
        if (file_put_contents($dir . $name . '_thumb' . '.jpg', $imagick) === false) {

            throw new Exception("Could not put contents.");
        }


        return $imagick->getImageBlob();
    }


}

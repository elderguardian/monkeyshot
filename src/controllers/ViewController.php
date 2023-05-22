<?php

class ViewController extends Controller
{

    public function index(IKernel $kernel)
    {
        $request = $kernel->get('IRequest');
        $image = $request->fetch('i');

        if (!$image) {
            return $this->view('error', [
                'message' => 'No image parameter given.'
            ]);
        }

        $imageExists = file_exists("static/$image");

        if (!$imageExists) {
            return $this->view('error', [
                'message' => 'Could not find this image.'
            ]);
        }

        $config = include('config.php');

        return $this->view('image', [
            'baseUrl' => $config['base_url'],
            'title' => $config['embed_title'],
            'color' => $config['embed_color'],
            'description' => $config['embed_description'],
            'imageUrl' => "/static/$image",
            'fileName' => $image,
        ]);
    }

}
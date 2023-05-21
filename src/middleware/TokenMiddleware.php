<?php

class TokenMiddleware implements IMiddleware
{

    private array $config;

    public function __construct()
    {
        $this->config = include('config.php');
    }

    public function canPass(IKernel $kernel): bool
    {
        $request = $kernel->get('IRequest');
        $response = $kernel->get('IResponse');

        $token = $request->fetch('token');

        if ($token == null) {
            $response->json([
                'message' => 'You are missing a token parameter!'
            ], 400);
            return false;
        }

        if ($token != $this->config['upload_secret']) {
            $response->json([
                'message' => 'The token you entered as a parameter is invalid!'
            ], 400);
            return false;
        }

        return true;
    }

}
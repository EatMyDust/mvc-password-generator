<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Generator;

class GeneratorController extends Controller
{
    public function generator($request, $response)
    {
        $model = new Generator();
        if($request->getMethod()==='post')
        {
            $model->loadData($request->getBody());
            if($model->validate())
            {
                $code = $model->generateCode();
                return $this->render("generator", ['model'=>$model, 'code'=>$code]);
            }
        }
        return $this->render("generator", ['model'=>$model]);
    }
}
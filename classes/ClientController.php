<?php

class ClientController extends Controller {

    public function actionIndex() {
        if(!App::$app->user->isAuthenticated) {
            return $this->goHome();
        }

        $models = Client::findAll();

        return $this->render("index", [
            "models" => $models
        ]);
    }

}

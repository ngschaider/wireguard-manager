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

    public function actionDelete() {
        if(!App::$app->request->isPostRequest) {
            return false;
        }
        if(!App::$app->user->isAuthenticated) {
            return;
        }

        $name = App::$app->request->post("name");
        Client::delete($name);

        return $this->redirect("client/index");
    }

    public function actionCreate() {
        $name = App::$app->request->post("name", "");
        $allowedIPs = App::$app->request->post("allowedIPs", "");

        $client = new Client();
        $client->name = $name;
        $client->allowedIPs = $allowedIPs;
        if($client->validate()) {
            $client->save();

            return $this->redirect("client/index");
        }

        return $this->render("form", [
            "name" => $name,
            "allowedIPs" => $allowedIPs,
        ]);
    }

}

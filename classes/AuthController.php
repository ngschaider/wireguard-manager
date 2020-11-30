<?php

class AuthController extends Controller {

    public function actionLogin() {
        if(App::$app->user->isAuthenticated) {
            return $this->goHome();
        }

		if(App::$app->request->isPostRequest) {
			$username = App::$app->request->post("username");
			$password = App::$app->request->post("password");

			if(isset(App::$app->users[$username]) && App::$app->users[$username] === $password) {
				App::$app->user->login($username);

                return $this->redirect("client/index");
			}
		}

        return $this->render("login");
	}

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect("site/index");
    }

}

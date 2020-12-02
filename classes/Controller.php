<?php

class Controller {

	protected $layout = "layouts/main";
	protected $title = "WireGuard Manager";

	protected function getControllerId() {
		$className = get_called_class();
		$controllerIdLength = strlen($className) - strlen("Controller");
		return strtolower(substr($className, 0, $controllerIdLength));
	}

	protected function render($viewName, $vars=[]) {
		$content = $this->renderPartial($viewName, $vars);

		$layoutFile = $this->findViewFile($this->layout);
		return $this->renderFile($layoutFile, [
			"content" => $content,
			"title" => $this->title,
		]);
	}

	protected function renderPartial($viewName, $vars=[]) {
		$viewFile = $this->findViewFile($this->getControllerId() . "/" . $viewName);
		return $this->renderFile($viewFile, $vars);
	}

	protected function findViewFile($viewId) {
		return App::$app->basePath . "/views/" . $viewId . ".php";
	}

	protected function renderFile($viewFile, $vars=[]) {
		ob_start();
		if(is_file($viewFile)) {
			extract($vars);
			require $viewFile;
		} else {
			throw new Exception("View file '" . $viewFile . "' not found!");
		}
		return ob_get_clean();
	}

	protected function css($fileName) {
		return "<link href='assets/css/" . $fileName . "' rel='stylesheet'>";
	}

	protected function js($fileName) {
		return "<script src='assets/js/" . $fileName . "'></script>";
	}

	protected function url($route) {
		return "?r=" . urlencode($route);
	}

	protected function goHome() {
		return $this->redirect("site/index");
	}

	protected function redirect($route) {
		$url = $this->url($route);
		$response = new Response();
		$response->setHeader("Location", $url);
		return $response;
	}

}

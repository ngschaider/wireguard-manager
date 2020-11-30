<html>
	<head>
		<title><?= $this->title ?></title>

		<?= $this->css("semantic.min.css"); ?>
	</head>
	<body>
		<div class="ui secondary  menu">
			<a class="active item" href="<?= $this->url("site/index") ?>">
				Home
			</a>
			<a class="item" href="<?= $this->url("client/index") ?>">
				Clients
			</a>
			<div class="right menu">
				<?php if(App::$app->user->isAuthenticated): ?>
					<a class="ui item" href="<?= $this->url("auth/logout") ?>">
						Logout
					</a>
				<?php else: ?>
					<a class="ui item" href="<?= $this->url("auth/login") ?>">
						Login
					</a>
				<?php endif; ?>
			</div>
		</div>

		<?= $content ?>

		<?= $this->js("semantic.min.js"); ?>
	</body>
</html>

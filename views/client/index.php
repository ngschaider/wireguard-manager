<div class="ui container">
    <div class="ui cards">
        <?php foreach($models as $model): ?>
            <div class="ui card">
                <div class="image">
                    <img src="assets/qr/<?= $model->name ?>.png">
                </div>
                <div class="content">
                    <a class="header">
                        <?= $model->name ?>
                    </a>
                    <!--<div class="meta">
                        <span class="date">Joined in 2013</span>
                    </div>-->
                    <div class="description">
                        <?= wordwrap($model->publicKey, 30, "<br>", true) ?>
                    </div>
                </div>
                <div class="extra content">
                    <div class="ui two buttons">
                        <a class="ui basic green button">Renew</a>
                        <form method="post" action="<?= $this->url("client/delete") ?>">
                            <input type="hidden" name="name" value="<?= $model->name ?>">
                            <input class="ui basic red button" type="submit" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a class="ui green button" href="<?= $this->url("client/create") ?>">Add</a>
</div>

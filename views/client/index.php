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
                        <input class="ui basic green button" type="button" value="Renew">
                        <input class="ui basic red button" type="button" value="Delete">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

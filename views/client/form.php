<div class="ui container">
    <form class="ui form" method="post" action="<?= $this->url("client/create") ?>">
        <div class="field">
            <label>Name</label>
            <input type="text" name="name" placeholder="hydrogen" value="<?= $name ?>">
        </div>
        <div class="field">
            <label>AllowedIPs</label>
            <input type="text" name="allowedIPs" placeholder="192.168.8.1" value="<?= $allowedIPs ?>">
        </div>
        <button class="ui button" type="submit">Create</button>
    </form>
</div>

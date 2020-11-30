<style type="text/css">
    body {
    }
    body > .grid {
        height: 100%;
    }
    .image {
        margin-top: -100px;
    }
    .column {
        max-width: 450px;
    }
</style>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <!--<img src="assets/images/logo.png" class="image">-->
            <div class="content">
                Log-in to your account
            </div>
        </h2>
        <form class="ui large form" method="post" action="<?= $this->url("auth/login") ?>">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                </div>
                <input type="submit" class="ui fluid large teal submit button" value="Login"></input>
            </div>
            <div class="ui error message"></div>
        </form>

        <div class="ui message">
            Default credentials are admin/admin
        </div>
    </div>
</div>

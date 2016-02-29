<div class="row">

    <div id="dashboard-main" class="span12">
<!--        <form id="create_note" class="form-horizontal" method="post" action="<?= site_url('api/create_note') ?>">
            <div class="input-append">
                <input tabindex="1" type="text" name="title" placeholder="Note Title" />
                <input tabindex="3" type="submit" class="btn btn-success" value="Create" />
            </div>

            <div class="clearfix"></div>

            <textarea tabindex="2" name="content"></textarea>

        </form>-->

        <div id="list_user">
            <span class="ajax-loader-gray"></span>
        </div>

        <div class="table-responsive">
            <table id="list_user" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Login</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>

    </div>
</div>
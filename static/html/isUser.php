<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 my-auto">
			<h3 class="text-center">
            Здравствуйте,  <? echo $_SESSION['username'] . "! "; ?>
			</h3>
		</div>
		<div class="col-md-1">
			 
        <a class="btn btn-success" href="http://localhost:9000/posts/add" role="button">Создать пост</a>
		</div>
		<div class="col-md-1">
			 
        <a class="btn btn-success" href="http://localhost:9000/user/logout" role="button">Выйти</a>
        </div>

	</div>
</div>
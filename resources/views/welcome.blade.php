<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="csrf-token" content="{!! csrf_token() !!}" />

        <title>Laravel</title>

				<link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    </head>
    <body>

				<div class="container">

					<div class="page-header">
						<h1>Taaklijst</h1>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">
							Nieuwe taak
						</div>
						<div class="panel-body">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Nieuwe taak" v-model="newtask" v-on:keyup.enter="addTask()">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" v-on:click="addTask()">OK</button>
								</span>
							</div><!-- /input-group -->
						</div>
					</div>


					<div class="panel panel-default">
						<div class="panel-heading">
							Overzicht
						</div>
						<div class="list-group">
							<a href="#" class="list-group-item" v-for="task in tasks" v-bind:class="{'completed':task.completed}" v-on:click.prevent="toggleTask(task)">@{{ task.title }}</a>
						</div>
					</div>

					<div class="btn-group btn-group-justified" role="group" aria-label="...">
					  <div class="btn-group" role="group">
					    <button type="button" class="btn btn-default">Alles</button>
					  </div>
					  <div class="btn-group" role="group">
					    <button type="button" class="btn btn-default">Open</button>
					  </div>
					  <div class="btn-group" role="group">
					    <button type="button" class="btn btn-default btn-danger" v-on:click="removeCompletedTasks()">Schoon op</button>
					  </div>
					</div>


				</div>

    		<script src="{{ elixir('js/app.js') }}"></script>

    </body>
</html>

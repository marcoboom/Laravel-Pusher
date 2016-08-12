<template>
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
		<table class="table">
			<tr v-for="task in tasks" track-by="id">
				<td>
						<a href="#" v-bind:class="{'completed':task.completed}" v-on:click.prevent="toggleTask(task)">{{ task.title }}</a>
				</td>
				<td>
						{{ task.user_name ? task.user_name : '-' }}</a>
				</td>
				<td width="50">
					<button class="btn btn-danger btn-xs" v-on:click.prevent="deleteTask(task)">x</button>
				</td>
			</tr>
		</table>

		</div>
	</div>
</template>

<script>
    export default {
		data: function()
		{
			return {
				tasks: [],
				newtask: ''
			}
		},

		ready: function()
		{
			this.getTasks();

			this.listen();
		},

		methods: {

			listen: function()
			{
				echo.channel('tasks')
					.listen('TaskCreated', function(event)
					{
						console.log(event.task);
						this.tasks.push(event.task);
					}.bind(this))
					.listen('TaskDeleted', function(event)
					{
						this.deleteTaskFromList(event.taskId);
					}.bind(this))
					.listen('TaskToggled', function(event)
					{
						this.updateTaskInList(event.task);
					}.bind(this));
			},

			getTasks: function()
			{
				this.$http({url:'/tasks', method:'GET'}).then(function(response)
				{
					this.tasks = response.data;

				}.bind(this), function(response)
				{
					console.log('no tasks');
				}.bind(this));

			},

			addTask: function()
			{
				if (this.newtask)
				{
					this.$http({url:'/tasks', method:'POST', body:{title:this.newtask}}).then(function(response)
					{
						this.tasks.push(response.data);
						this.newtask = '';

					}.bind(this), function(response)
					{

					}.bind(this));
				}
			},

			toggleTask: function(task)
			{
				this.$http({url:'/tasks/'+task.id, method:'PUT', body:{completed:!task.completed}});

				task.completed = !task.completed;
			},

			updateTaskInList(task)
			{
				this.tasks = this.tasks.map(function (item) {
					if (item.id == task.id) item = task;
					return item;
				}.bind(task));

			},

			removeCompletedTasks: function()
			{
				this.$http({url:'/tasks', method:'GET', params:{action:'cleanup'}}).then(function(response)
				{
					this.tasks = response.data;
				}.bind(this),
				function(response)
				{
					console.log('cleanup failed');
				});
			},

			deleteTask: function(task)
			{
				this.$http({url:'/tasks/'+task.id, method:'DELETE'});
			},

			deleteTaskFromList(taskId)
			{
				this.tasks = this.tasks.filter(function (item) {
  				return item.id != taskId;
				}.bind(taskId));

			}
		}
  }
</script>

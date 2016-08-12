
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

 window.Pusher = require('pusher-js');

 import Echo from "laravel-echo"

 window.echo = new Echo({key:'abbaac7da82e5cb49b2a', broadcaster:'pusher', cluster: 'eu', encrypted: true});

 echo.channel('tasks').listen('TaskCreated', function(event)
 {
 	 console.log(event);
 	 app.tasks.push(event.task);
 });



Vue.component('example', require('./components/Example.vue'));

var app = new Vue({
    el: 'body',

		data: {
				tasks: [],
				newtask: ''
		},

		ready: function()
		{
			this.$http({url:'/tasks', method:'GET'}).then(function(response)
			{
				this.tasks = response.data;

			}.bind(this), function(response)
			{
				console.log('no tasks');
			}.bind(this));
		},

		methods: {

			addTask: function()
			{
				if (this.newtask)
				{
					this.$http({url:'/tasks', method:'POST', body:{title:this.newtask}}).then(function(response)
					{
						//this.tasks.push(response.data);
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

			removeCompletedTasks()
			{
				this.$http({url:'/tasks', method:'GET', params:{action:'cleanup'}}).then(function(response)
				{
					this.tasks = response.data;
				}.bind(this),
				function(response)
				{
					console.log('cleanup failed');
				});
			}
		}

});

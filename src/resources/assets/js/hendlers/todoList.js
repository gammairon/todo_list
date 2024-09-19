import Sender from "../helpers/sender";

const todoList = {
    modalOpen: 'create',

    currentActiveItem: 0,

    getRequestUrl: (endpoint) => {
        return '/api/'+endpoint+'?api_token='+window.apiToken
    },
    hideForm(){
        $('#todo_create').hide();
        $('#todo_modal #save_todo').hide();
    },
    resetForm(){
        $('#todo_create')[0].reset();
    },
    showForm(){
        $('#todo_create').show();

        $('#todo_modal #save_todo').show();
        $("#todo_modal .flash").remove();
    },
    addTodoItemToList(board, itemHtml){
        $('.to-do-list .'+board+'-items').prepend(itemHtml)
    },
    updateTodoItemToList(todoItem){
        $('#item-'+todoItem.id).find('h4').text(todoItem.title);
        let status = $('#item-'+todoItem.id).find('.status');

        status.text(todoItem.status);

        if (!status.hasClass(todoItem.status)){
            let htmlTodoItem = $('#item-'+todoItem.id).remove();
            $('.'+todoItem.status+'-items').prepend(htmlTodoItem);
        }
        status.removeClass('done active');
        status.text(todoItem.status);
        status.addClass(todoItem.status);

    },
    removeTodoItemFromList(id){
        $('#item-'+id).remove()
    },
    fillForm(todoItem){
        $('#title').val(todoItem.title);
        $('#description').val(todoItem.description)
        $("#status").val(todoItem.status).change();
    },
    addContentModalBody(html){
        $('.modal-body').append(html);
    },
    showFormErrors(errors){
        this.hideErrors();
        for (const errorKey in errors) {
            $('#todo_create #'+errorKey+'_help').text(errors[errorKey]);
            $('#todo_create #'+errorKey+'_help').closest('.form-group').addClass('has-error');
        }
    },
    hideErrors(){
        $('#todo_create .form-group').removeClass('has-error');
        $('#todo_create .help-block').text('');
    },
    createTodo: () => {
        let formData = new FormData($('#todo_create').get(0));

        Sender.addLoaderBlock($('#todo_modal'))

        Sender.send("POST", todoList.getRequestUrl('todo-list'), formData,
            (response) => {

                //Hide Form
                todoList.hideForm()

                //Insert response html
                todoList.addContentModalBody(response.message);
                todoList.addTodoItemToList(response.board, response.todoItem);


                Sender.removeLoaderBlock($('#todo_modal'))
            },
            (jqXHR, textStatus, errorThrown) => {
                Sender.removeLoaderBlock($('#todo_modal'))

                if (jqXHR.status === 422){
                    let errors = JSON.parse(jqXHR.responseText);
                    todoList.showFormErrors(errors)
                }
            });
    },
    updateTodo: () => {
        let formData = new FormData($('#todo_create').get(0));

        Sender.addLoaderBlock($('#todo_modal'))
        formData.append('_method', 'PUT')

        Sender.send("POST", todoList.getRequestUrl('todo-list/'+todoList.currentActiveItem), formData,
            (response) => {

                //Hide Form
                todoList.hideForm()

                //Insert response html
                todoList.addContentModalBody(response.message);
                if (response.todoItem !== 0)
                    todoList.updateTodoItemToList(response.todoItem);


                Sender.removeLoaderBlock($('#todo_modal'))
            },
            (jqXHR, textStatus, errorThrown) => {
                Sender.removeLoaderBlock($('#todo_modal'))

                if (jqXHR.status === 422){
                    let errors = JSON.parse(jqXHR.responseText);
                    todoList.showFormErrors(errors)
                }
            });
    },
    deleteTodo: () => {
        Sender.addLoaderBlock($('#todo_modal'))
        Sender.send("DELETE", todoList.getRequestUrl('todo-list/'+todoList.currentActiveItem), [],
            (response) => {

                //Hide Form
                todoList.hideForm()
                $("#todo_modal .flash").remove();

                //Insert response html
                todoList.addContentModalBody(response.message);
                if (response.id > 0)
                    todoList.removeTodoItemFromList(response.id);

                Sender.removeLoaderBlock($('#todo_modal'))
            },
            (jqXHR, textStatus, errorThrown) => {

            });
    }
}

$( document ).ready(  () => {

    if (!$('.to-do-list').length)
        return;


    //Events
    $('.to-do-list').on('click', '.delete_todo',  (e) => {
        todoList.modalOpen = 'delete';

        todoList.currentActiveItem = $(e.target).closest('.item').data('id');

        $('#todo_create').hide();
        todoList.addContentModalBody("<h4 class='flash'>Вы уверены</h4>")
        $('#todo_modal').modal('show')

    })

    $('.to-do-list').on('click', '.edit_todo',  (e) => {
        todoList.modalOpen = 'update';

        todoList.currentActiveItem = $(e.target).closest('.item').data('id');
        $('#todo_modal').modal('show');
        Sender.addLoaderBlock($('#todo_modal'));

        Sender.send("GET", todoList.getRequestUrl('todo-list/'+todoList.currentActiveItem+'/edit'), {id: todoList.currentActiveItem},
            (response) => {


                //Insert response html
               if (response.find === 1){
                   todoList.fillForm(response.todoItem)
               }
               else{
                   todoList.hideForm();
                   todoList.addContentModalBody(response.message);
               }


                Sender.removeLoaderBlock($('#todo_modal'))
            },
            (jqXHR, textStatus, errorThrown) => {});

    })

    $('.to-do-list').on('click', '.view_todo',  (e) => {
        todoList.modalOpen = 'view';

        todoList.currentActiveItem = $(e.target).closest('.item').data('id');
        todoList.hideForm();
        $('#todo_modal').modal('show');
        Sender.addLoaderBlock($('#todo_modal'));

        Sender.send("GET", todoList.getRequestUrl('todo-list/'+todoList.currentActiveItem), {id: todoList.currentActiveItem},
            (response) => {

                //Insert response html
                todoList.addContentModalBody(response.message);

                Sender.removeLoaderBlock($('#todo_modal'))
            },
            (jqXHR, textStatus, errorThrown) => {});

    })

    $('#create_todo').on('click', (e) => {
        todoList.modalOpen = 'create';
        $('#todo_modal').modal('show');
    })


    $('#save_todo').on('click', (e) => {

        switch (todoList.modalOpen){
            case 'create':
                todoList.createTodo();
                break;
            case 'update':
                todoList.updateTodo();
                break;
            case 'delete':
                todoList.deleteTodo();
                break;
        }
    })



    $('#todo_modal').on('hidden.bs.modal', (e) => {
        todoList.hideErrors();
        todoList.resetForm();
        todoList.showForm();
        todoList.currentActiveItem = 0;
    })
} );

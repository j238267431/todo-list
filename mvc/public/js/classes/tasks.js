class Tasks {

  options = {
    statuses: ['new', 'progress', 'completed']
  }

  constructor() {
    $(".card").draggable({
        connectToSortable: ["#new", "#progress", "#completed"],
        start: function( event, ui ) {
          document.body.style.cursor = 'move';
        }
    });
    this.assignSortable(this);
  }

  assignSortable(that){
    console.log(this)
    for(let i in this.options.statuses){
      $('#'+this.options.statuses[i]).sortable({
        receive: function( event, ui) {
          that.changeStatus($(this), ui);
        }
      });
    }
   }
  changeStatus(entity, ui){
    let taskId = $(ui.item).data('cardid');
    $.ajax({
      data: {taskId, status: entity.attr('id')},
      url: "http://localhost:8099/task/updateStatus",
    }).done(function() {
      console.log('done')
    });
  }
}

export default Tasks;
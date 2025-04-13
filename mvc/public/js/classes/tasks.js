class Tasks {

  options = {
    stages: [],
    stagesArea: 'stagesArea'
  }

  constructor() {
    let stages = $('[data-blockname="stages"]');
    this.setOptions('stages', stages);
    console.log('$stages', stages);
    $(".card").draggable({
        connectToSortable: this.getId(),
        start: function( event, ui ) {
          document.body.style.cursor = 'move';
        }
    });
    this.assignSortable(this, 'stages');
    this.assignSortable(this, 'stagesArea');
  }

  getId(){
    let arr = this.options.stages.map((v) => {
      return '#'+v;
    });
    return arr;
  }

  setOptions(optionProperty, data){
    switch(true){
      case typeof data === 'object':
        let arr = [];
        $(data).each(function(){
          arr.push($( this ).attr('id'))
        })
        this.options[optionProperty] = arr;
        console.log('arr',this.options[optionProperty]);
      break;
      case typeof data === 'string':
        this.options[optionProperty] = data;
      break;
    }
  }

  assignSortable(that, property){
    console.log(this)
    switch(true){
      case typeof this.options[property] === 'object':
        for(let i in this.options[property]){
          $('#'+this.options[property][i]).sortable({
            receive: function( event, ui) {
              that.changeStatus($(this), ui);
            }
          });
        }
      break;
      case typeof this.options[property] === 'string':
        $('#'+this.options[property]).sortable({
          stop: function( event, ui) {
            let newOrder = $(this).sortable('toArray');
            that.changeStageOrder($(this), ui);

            var refreshPositions = $(this).sortable('refreshPositions');
          },

        });
      break;

    }

   }
  changeStatus(entity, ui){
    let taskId = $(ui.item).data('cardid');
    $.ajax({
      method: 'post',
      data: {taskId, status: entity.attr('id')},
      url: window.location.origin+"/task/updateStatus",
    }).done(function() {
      console.log('done')
    });
  }
  changeStageOrder(entity, ui){
    console.log('ui', ui);
    let newOrder = JSON.stringify(entity.sortable('toArray'));
    $.ajax({
      method: 'post',
      data: {newOrder},
      url: window.location.origin+"/stage/changeOrder",
    }).done(function() {
      console.log('done')
    });
  }
}

export default Tasks;
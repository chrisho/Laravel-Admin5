jQuery.extend({
    confirmModal: function(content, callback) {
        $('.modal ,.modal-backdrop').hide();
        
        var modalName = 'confirmModal';
        if (!$('#' + modalName).is('div')) {
            $('body').append(
                    '<div id="' + modalName + '" class="modal modal-danger">'
                    + '<div class="modal-dialog">'
                    + '<div class="modal-content">'
                    + '<div class="modal-body"></div>'
                    + '<div class="modal-footer">' 
                    + '<button data-dismiss="modal" class="btn btn-outline btn-sure">确认</button>'
                    + '<button data-dismiss="modal" class="btn btn-outline pull-left" type="button">取消</button>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    );
        }
        $('#'+modalName+' .btn-sure').unbind('click').bind('click', callback);
        $('#'+modalName+' .modal-body').html( content );
        $('#' + modalName).modal();
    },
    tipsModal: function(content) {
      
        $('.modal ,.modal-backdrop').hide();
        var modalName = 'tipsModal';
        if (!$('#' + modalName).is('div')) {
            $('body').append(
                    '<div id="' + modalName + '" class="modal modal-info">'
                    + '<div class="modal-dialog">'
                    + '<div class="modal-content">'
                    + '<div class="modal-body"></div>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    );
        }
        $('#'+modalName+' .modal-body').html( content );
        $('#' + modalName).modal();
    },
    progressModal: function() {
        $('.modal ,.modal-backdrop').hide();
        var modalName = 'progressModal';
        if (!$('#' + modalName).is('div')) {
            $('body').append(
                    '<div id="' + modalName + '" class="modal">'
                    + '<div class="modal-dialog">'
                    + '<div class="modal-content">'
                    + '<div class="progress active" style="margin-bottom:0">' 
                    + '<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'                    
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '</div>');
        }
        $('#' + modalName).modal();
    },
    hideModal: function() {
        $('.modal ,.modal-backdrop').remove();
    }
});
$('head').append("<style>.modal .close{bottom:15px; float:right; opacity:1; filter: none; position: relative; right: -10px;}</style>");
<?php

$url = uploads_url();

$hash = Tools::encrypt(GlobalsRevSlider::MODULE_NAME);



?>
<!-- <link rel="stylesheet" id="jquery-uploadify-css" media="all" type="text/css" href="/dental/modules/revsliderprestashop/rs-plugin/fileuploader/uploadifive.css"> -->

<style type="text/css">
    #main,.page-sidebar #content{
        padding:0;
        margin:0;
    }
    .bootstrap.panel,
    .bootstrap .page-head,#footer,
    #header,#nav-sidebar,
    #top_container #header,
    #top_container #footer,
    #top_container #content > .table{

        display: none;

    }

    #top_container #main{

       min-height: 0;

       height: auto;

    }

    .ls-wrap .row-fluid .span9{
        width:58%;
    }

    #selectable {

        list-style: none;
        position: relative;
        padding: 0;
        
    }

    #selectable li 

    {                

        float: left;

        position: relative;

        width: 150px;

        margin-left: 2.5641%;

        min-height: 30px;

        margin-bottom: 2.5641%;

        -moz-box-shadow:    inset 1px 1px 10px #cccccc;

        -webkit-box-shadow: inset 1px 1px 10px #cccccc;

        box-shadow:         inset 1px 1px 10px #cccccc;

    }

    #selectable li.last {} 

    #selectable li a{

        display: block;



        border: 5px solid transparent;               

    }

    #selectable  li.ui-selected  a

    {

        border-color: #0084FF;                

    }
      
    .uploadifive-button {
	    float: left;
	    margin-right: 10px;
    }
    #queue {
        border: 1px solid #E5E5E5;
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 300px;
    }
</style>            

</style>

<div style="width: 100%" class="ls-wrap">

    <div style="width: 100%" class="container">                               

        <div class="row-fluid">

            <div class="span9">

                <div class="row-fluid">

                    <div class="span12">

                        <ul class="nav nav-tabs" id="imageTab">

                            <li class="active"><a data-toggle="tab" href="#divImageList">Gallery</a></li>

                            <li class=""><a data-toggle="tab" href="#divImageUpload">Upload</a></li>                    

                        </ul>

                        <div id="myTabContent" class="tab-content">

                            <div id="divImageList" class="tab-pane active">                                

                                <?php 

                                echo RevSliderAdmin::get_uploaded_files_markup(RevSliderAdmin::get_uploaded_files_result());

                                /*if (!empty($results)): ?>

                                    <ul id='selectable' class=''>

                                        <?php

                                        for ($num = 0; $num < count($results) - 2; $num++):

                                            $img = $results[$num];

                                            if (($num + 1) % 4 === 1):

                                                ?>

                                                <li data-image="<?php echo $img ?>" class="last"><a  href="javascript:void()"><img alt="<?php echo $img ?>" src="<?php echo $url . $img ?>" /></a></li>

                                            <?php else: ?>

                                                <li data-image="<?php echo $img ?>"><a  href="javascript:void()"><img alt="<?php echo $img ?>" src="<?php echo $url . $img ?>" /></a></li>                                    

                                            <?php endif ?>

                                        <?php endfor; ?>

                                    </ul>

                                <?php endif;*/ ?>                                       

                            </div>

                            <div id="divImageUpload" class="tab-pane fade">

                                <div class="well">

                                	<form>
		                                <div id="queue"></div>
		                                <input id="file_upload" name="file_upload" type="file" multiple="true">
		                                <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a>
	                                </form>                

                                </div>

                            </div>

                        </div>                                

                    </div>

                </div>                        

            </div>

            <div class="span3">

                <div class="well">

                    <div id="imgContainer" class="clearfix">

                        <p style="min-height: 80px"><strong>Preview</strong></p>

                    </div>

                    <div class='btn-group'>

                        <select id='image_size'>

                            <option value=''>Full</option>

                            <option value='thumbnail'>Thumbnail</option>

                            <option value='medium'>Medium</option>

                            <option value='large'>Large</option>

                        </select>

                    </div>

                    <div class="btn-group">

                        <button id="txtImageInsert" class="btn">Insert</button>

                        <button id="txtImageDelete" class="btn">Delete</button>

                    </div>

                </div>

            </div>

        </div>

    </div>            

</div>

<script type="text/javascript">

<?php $timestamp = time(); ?>

    var imgsizes = ['<?php echo GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL?>',

                        '<?php echo GlobalsRevSlider::IMAGE_SIZE_MEDIUM?>',

                        '<?php echo GlobalsRevSlider::IMAGE_SIZE_LARGE?>'];

    $(function() {

        

        

    

        $('#imageTab a').click(function(e) {

            e.preventDefault();

            $(this).tab('show');

        });

        $('#divImageList ul li a').click(function(){

            return false;

        });

        

        var splitFileparts = function(filename, size){

            var filerealname = filename.substr(0,filename.lastIndexOf('.'));

            var fileext = filename.substr(filename.lastIndexOf('.'),filename.length - filename.lastIndexOf('.'));

            var newfilename = filerealname+'-'+imgsizes[size]+'x'+imgsizes[size]+fileext;

            return [newfilename,filerealname,fileext];

        };

        

        

        var selectableCb = function(){ 

            $("#selectable").selectable({

                selected: function(event, ui) {

                    $("#imgContainer").empty();

                    $(ui.selected).children('a').children('img').clone().appendTo("#imgContainer");

                    $("#txtImageInsert, #txtImageDelete").val($(ui.selected).data('image'));

                }

            });

        };

        selectableCb();

        $('#txtImageInsert').click(function(){

        

            var isize = $('#image_size > option:selected').val();

            var filename = $(this).val();

            if(filename == '') return false;

            

            var nfilename = '';

            switch(isize){

                case 'thumbnail':                    

                    nfilename = splitFileparts(filename,0);                    

                    filename = nfilename[0];

                    break;

                case 'medium':                    

                    nfilename = splitFileparts(filename,1);

                    filename = nfilename[0];

                    break;

                case 'large':                    

                    nfilename = splitFileparts(filename,2);                    

                    filename = nfilename[0];

                    break;

                default:

                    break;

            }

            

            parent.iframe_img = '<?php echo $url?>'+filename;

            parent.tb_remove();

            parent.getImg();

        });

        $('#txtImageDelete').click(function(){

            var img = $(this).val();

            var data = {};

            data.img = img;

            if(img !== undefined || img !== '')

            UniteAdminRev.ajaxRequest("delete_uploaded_image",data,function(response){

                if(response.success !== undefined && response.success == '1'){

                    $("#imgContainer").html('');

                    $(this).val('');

                    $('#txtImageInsert').val('');

                    $('#divImageList').html(response.output);  

                    selectableCb();

                }

            });

        });

        <?php $timestamp = time();?>
	
		$('#file_upload').uploadifive({
				'auto'             : true,
				'checkScript'      : 'check-exists.php',
				'fileType'         : 'image/',
				'formData'         : {
									   'timestamp' : '<?php echo $timestamp;?>',
									   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				                     },
                'uploadScript' : '<?php echo Context::getContext()->link->getAdminLink('Revolutionslider_ajax') ?>&revControllerAction=uploadimage&security_key=<?php echo $hash;?>',
				'queueID'          : 'queue',				
				'onUploadComplete' : function(file, data) {
                     console.log(file.xhr.responseText); 
                     data = $.parseJSON(data);

                

                if (data.error_on === undefined || data.error_on === 0) {

                    

//                    $("#txtImageInsert, #txtImageDelete").val(file.name);

//                    var path = '<?php echo uploads_url() ?>';                    

//                    console.log(splitFileparts(file.name,0));                    

//                    $("#imgContainer").html('<img src="' + path + '" alt="' + file.name + '" />');

                    

                    UniteAdminRev.ajaxRequest("get_uploaded_images",data,function(response){

                        if(response.success !== undefined && response.success == '1'){                            

                            $("#txtImageInsert, #txtImageDelete").val(response.latest);

                            var path = '<?php echo uploads_url() ?>';

                            var newsimg = splitFileparts(response.latest,0);                             

                            $("#imgContainer").html('<img src="' + path + newsimg[0] + '" alt="' + response.latest + '" />');                            

                            $('#divImageList').html(response.output);  

                            selectableCb();

                        }

                    });

                    

                }

                else {

                    //console.log(response + data);

                    $('#txtImageInsert').val('');

                    $('#txtImageDelete').val('');

                    if(data.error_details !== undefined){

                        $('#imgContainer').html("<span style='color:#ff0000'>"+data.error_details+"</span>");

                        setTimeout(function(){

                            $('#imgContainer').html('<p style="min-height: 80px">'+

                                                '<strong>Preview</strong></p>');

                        },5000);

                    }

                    

                }

                     }
			});
		

            // Put your options here

        



    });

</script>
<html ng-app="ocrSelectAngularApp">

<head>
        <title>OCR Select</title>

        <meta charset="UTF-8">
        <script src="_.js/jq.js"></script>    

        <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/darkly/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="_.css/style.css">

</head>

<body ng-controller="OcrSelectCtrl as ocrselect">
        <br>
        <br>
        <br>


        <div id="document" class="modal-dialog parent" role="document">
                <div class="modal-content">
                        <form >
                                <div class="modal-header">
                                        <h5 class="modal-title">Athentication</h5>

                                </div>

                                <div class="modal-body">
                                        <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                </div>
                                                <input id="email" type="email" class="form-control" required>

                                        </div>
                                        <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">Password</span>
                                                </div>
                                                <input id="pwd" type="password" class="form-control" required>

                                        </div>
                                </div>

                                <div class="modal-footer">
                                        <input value="Log-In" type="submit" class="btn btn-primary" ng-click="logIn();" />

                                </div>
                        </form>
                </div>
        </div>


        <center id="sys">
                <div class="card text-white bg-primary mb-3" style="max-width: 60rem;">
                        <div class="card-header">NowScan<input type="button" value="X" class="float-right btn btn-secondary btn-sm" ng-click="logout();"/></div>
                        
                        <div class="card-body">

                                <div class="row float-right">
                                        <div>
                                       
                                                <div class="card text-white bg-primary mb-1" style="max-width: 20rem;">
                                                        <div class="card-header">Controls</div>
                                                        <div class="card-body">
                                                                <button id="uploadit" type="button" class="btn btn-secondary btn-block ">Upload File</button>
                                                                <input on-file-change="ocrselect.fileChangeHandler;" id="img-input" type="file" name="pic" accept="image/*, application/pdf"
                                                                        hidden>
                                                                <br>
                                                                <div class="btn-group btn-block" role="group" aria-label="Basic example">

                                                                        <button type="button" class="btn btn-secondary btn-block btn-sm" ng-click="prevp();">&laquo; Prev </button>
                                                                        <button type="button" class="btn btn-secondary btn-sm" ng-click="zoomIn();"> &#43;</button>
                                                                        <button type="button" class="btn btn-secondary btn-sm" ng-click="dragIt();"> &#10019;</button>
                                                                        <button type="button" class="btn btn-secondary btn-sm" ng-click="resetIt();">&#8634;</button>
                                                                        <button id="crpt" type="button" class="btn btn-secondary btn-sm " ng-click="cropIt();"> &#9986;</button>
                                                                        <button type="button" class="btn btn-secondary btn-sm" ng-click="zoomOut();"> &#45;</button>
                                                                        <button type="button" class="btn btn-secondary btn-block btn-sm" ng-click="nextp();"> Next &raquo;</button>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <!-- <label>Language:</label> -->
                                                               
                                                                <!-- <label>API:</label> -->
                                                                <select class="form-control" id="ocrapi" ng-click="Api();">
                                                                        <option value="0">Google API</option>
                                                                        <option value="1">Teseract JS</option>
                                                                        <option disabled>Other's</option>
                                                                </select>
                                                                <select class="form-control" ng-model="ocrselect.langs.selectedLang" name="language" id="language" ng-options="lang as lang for lang in ocrselect.langs.list" >
                                                                </select>
                                                                <!-- <label>Page:</label> -->
                                                                <select class="form-control" ng-class="ocrselect.dropZone" ng-model="ocrselect.pdf.currentPage" name="pageSelect" id="pageSelect"
                                                                        ng-options="page as page for page in ocrselect.pdf.pageList"
                                                                        ng-change="ocrselect.onPageSelect(ocrselect.pdf.currentPage)">
                                                                </select>


                                                        </div>
                                                </div>

                                                <div class="card text-white bg-primary mb-1" style="max-width: 20rem;">
                                                        <div class="card-header">Snap view</div>
                                                        <div class="card-body">
                                                                <div id="results-area" class="outer">
                                                                        <canvas id="test-area" class="inner">
                                                                        </canvas>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="card text-white bg-primary " style="max-width: 20rem;">
                                                        <div class="card-header">Fields</div>
                                                        <div class="card-body">
                                                                <div class="input-group ">

                                                                        <!-- <div id="holder"> -->

                                                                        <!-- <input class="form-control form-control-sm" type="text" placeholder=".form-control-sm" id="inputSmall"> -->
                                                                        <!-- 
                                                                                <div id='TextBoxesGroup' >
                                                                                        <div id="TextBoxDiv1" class="input-group-prepend ">
                                                                                                <label class="editable input-group-text ">Field #1 : </label>
                                                                                                <input type='textbox' class="form-control " id='field1'>
                                                                                                
                                                                                        </div>
                                                                                </div>
                                                                              
                                                                                <br>
                                                                                <input type='button' value='Remove Fields' id='removeButton' class="btn btn-secondary btn-block"> -->



                                                                        <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                        <span class="input-group-text ">Field #1:</span>
                                                                                </div>
                                                                                <input id='field1' type="text" class="form-control form-control-sm">


                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                        <span class="input-group-text ">Field #2:</span>
                                                                                </div>
                                                                                <input id='field2' type="text" class="form-control form-control-sm">


                                                                        </div>
                                                                        <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                        <span class="input-group-text ">Field #3:</span>
                                                                                </div>
                                                                                <input id='field3' type="text" class="form-control form-control-sm">


                                                                        </div>
                                                                        <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                        <span class="input-group-text ">Field #4:</span>
                                                                                </div>
                                                                                <input id='field4' type="text" class="form-control form-control-sm">


                                                                        </div>
                                                                        <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                        <span class="input-group-text ">Field #5:</span>
                                                                                </div>
                                                                                <input id='field5' type="text" class="form-control form-control-sm">


                                                                        </div>



                                                                        <br>
                                                                        <a id='saveit' download="" style="display:none;" />

                                                                        <a href="#" onclick="downloadPDF();" class="btn btn-secondary btn-block btn-sm">Save</a>




                                                                        <!-- </div> -->


                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>



                                <div class="float-left ">
                                        <div id="container" class="container crosshair">
                                                <div id="image-section">

                                                        <div id="image-area" class="drop-zone" on-drag-over="ocrselect.dragOverHandler" on-drag-end="ocrselect.dragEndHandler" on-drop="ocrselect.dropHandler">

                                                                <!-- <object class="thisocr" id="thisocr" type="text/html" data="./nonocr/main.html"
                                                        style="width:100%; height:100%; margin:0%; " scrolling="no" > 
                                        </object> -->

                                                                <canvas class="uploaded-img" id="uploaded-img" ng-mousedown="ocrselect.initBox($event)" ng-mousemove="ocrselect.drawBox($event)"
                                                                        ng-mouseup="ocrselect.captureBox($event)">

                                                                </canvas>




                                                                <div ng-class="ocrselect.isActive" ng-style="ocrselect.boxSelect" id="box-select">
                                                                </div>

                                                                <div id="pdfContainer" class="pdf-content">
                                                                </div>
                                                        </div>


                                                        <form id="pdf-controls">
                                                        </form>

                                                </div>
                                        </div>
                                </div>


                        </div>
                </div>



        </center>

        <script src="_.js/drag.js"></script>    
        <script src="_.js/angular.min.js"></script>
        <script src="_.js/angular-route.min.js"></script>
        <script src="_.js/angular-resource.min.js"></script>
        <script type="text/javascript" src="_.js/textlayerbuilder.js"></script>
        <script src='https://cdn.rawgit.com/naptha/tesseract.js/1.0.10/dist/tesseract.js'></script>
        <script type="text/javascript" src="_.js/app.js"></script>
        <script type="text/javascript" src="_.js/allFactories.js"></script>
        <script type="text/javascript" src="_.js/allControllers.js"></script>
        <script type="text/javascript" src="_.js/pdf.js"></script>




</body>

</html>
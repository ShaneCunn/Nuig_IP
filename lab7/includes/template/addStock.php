<!-- Button to trigger modal -->
<a href="#myModal" role="button" data-toggle="modal" aria-hidden="true" class="btn btn-info btn-lg"><span
        class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Stock</a>
<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"> &times;</button>
                <h4 class="modal-title">Add Stock Form</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info"><a href="#" class="close" data-dismiss="alert"
                                                             aria-label="close">&times;</a>
                                File uploads on the nuig server is currently disabled
                            </div>
                            <form class="form-horizontal" action="" method="POST">

                                <fieldset>

                                    <div class="control-group">
                                        <label class="control-label" for="username">Price</label>
                                        <div class="controls">
                                            <input type="number" min="0" id="sale_price" name="sale_price"
                                                   placeholder=""
                                                   class="form-control input-lg">
                                            <p class="help-block">Please enter a Sale Price for the
                                                product</p>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="email">Product name</label>
                                        <div class="controls">
                                            <input type="text" id="product_name" name="product_name"
                                                   placeholder=""
                                                   class="form-control input-lg">
                                            <p class="help-block">Please enter a Product name</p>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="product">Product
                                            Description</label>
                                        <div class="controls">
                                            <input type="text" id="text_desc" name="text_desc"
                                                   placeholder=""
                                                   class="form-control input-lg">
                                            <p class="help-block">Please enter a product description</p>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="image file">Image File
                                            name</label>
                                        <div class="controls">
                                <span class="btn btn-info btn-file">
                                 Browse <input type="file" name="image_filename">
                                                        </span>

                                            <p class="help-block">Allowed extensions (<code>jpeg</code>,
                                                <code>jpg</code>,
                                                <code>gif</code>, and <code>png</code>)</p>
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <!-- Button -->
                                        <div class="controls">
                                            <button class="btn btn-success" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>

                    </div>
                </div><!-- End of Modal body -->
            </div><!-- End of Modal content -->
        </div><!-- End of Modal dialog -->
    </div><!-- End of Modal -->
</div> <!-- /.container -->
</div>

</div>
<br>



<form action="<?= url('/products')?>" method="post" enctype="multipart/form-data">
    <h3 class="mb-3">Create new Product</h3>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?= $this->component('input',[
                        'name'=>'title',
                        'label'=>'Product title',
                        'id' => 'title',
                        'error'=> error('title'),
                        'value' => old('title')
                    ]) ?>

                    <?= $this->component('input',[
                        'name'=>'price',
                        'label'=>'Price',
                        'id' => 'price',
                        'error'=> error('price'),
                        'type' => 'number',
                        'value' => old('price')
                    ]) ?>
                  
                  <?= $this->component('textarea',[
                        'name'=>'description',
                        'label'=>'Description',
                        'id' => 'description',
                        'error'=> error('description'),
                        'value' => old('description')
                    ]) ?>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
            <div class="card-header">Product image</div>
                <div class="card-body">
                    <?php if(error('image')) : ?>
                        <div class="alert alert-danger"><?= error('image') ?></div>
                        <?php endif?>
                    <div class="dropzone">
                        <div class="dropzone-box">
                            <input type="file" id="image" class="d-none" name="image" accept="image/*">
                            <div class="dropzone-placeholder">
                                <span>Drag and drop image here or click to select</span>
                            </div>
                        </div>
                        <div class="dropzone-preview">
                            <img id="preview" style="width:100%;object-fit:cover" src="" alt="Preview Image">
                            <div class="dropzone-actions">
                                <button id="changeImage" type="button" class="btn btn-primary">Change Image</button>
                                <button id="removeImage" type="button" class="btn btn-danger">Remove Image</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="py-4">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
</form>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>Products List</span>
    <a href="<?= url('/products/create') ?>" class="btn btn-sm btn-primary">Create new Product</a>
  </div>
  <div class="card-body">

    <?php if (session()->hasFlash('success')) : ?>
      <div class="alert alert-success"><?= session()->getFlash('success') ?></div>
    <?php endif ?>
  
    <?php if (session()->hasFlash('error')) : ?>
      <div class="alert alert-error"><?= session()->getFlash('error') ?></div>
    <?php endif ?>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
           
            <th scope="col">
              <a href="?sort=id&dir=<?= ($sort === 'id' && $dir === 'asc') ? 'desc' : 'asc' ?>">ID <?= ($sort === 'id' && $dir === 'asc') ? '&#x25B2;' : '&#x25BC;' ?></a>
            </th>
            <th scope="col">
              Product
            </th>
            <th scope="col">
              <a href="?sort=title&dir=<?= ($sort === 'title' && $dir === 'asc') ? 'desc' : 'asc' ?>">Product title <?= ($sort === 'title' && $dir === 'asc') ? '&#x25B2;' : '&#x25BC;' ?></a>
            </th>
            <th scope="col">
              <a href="?sort=price&dir=<?= ($sort === 'price' && $dir === 'asc') ? 'desc' : 'asc' ?>">Price <?= ($sort === 'price' && $dir === 'asc') ? '&#x25B2;' : '&#x25BC;' ?></a>
            </th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) : ?>
            <tr>
              <td scope="row"><?= $product->id ?></td>
              <td>
                <img class="rounded" src="<?= $product->image ?>" alt="<?= $product->title ?>" style="width:80px;object-fit:cover;">
              </td>
              <td scope="row"><?= $product->title ?></td>
              <td scope="row">$<?= $product->price ?></td>
              <td>
                <a href="<?= url("/products/$product->id/edit") ?>" class="btn btn-sm btn-success">Edit</a>
                <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $product->id ?>">Delete</button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <?= $this->component('pagination', ['pagination' => $pagination]) ?>

  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this product?</p>
      </div>
      <form method="post" id="deleteForm">
        <input type="hidden" name="_METHOD" value="DELETE">
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
</div>

<script defer>
  // Get all delete buttons
  const deleteButtons = document.querySelectorAll('.delete-btn');

  // Get the confirmation modal and confirm delete button
  const confirmationModal = new bootstrap.Modal("#confirmationModal")
  const confirmDeleteButton = document.getElementById('confirmDelete');
  const deleteForm = document.getElementById('deleteForm');

  // Add event listeners to delete buttons
  deleteButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Get the product ID
      const productId = button.dataset.id;

      // Set the delete action URL
      const deleteUrl = `<?= url('') ?>/products/${productId}`;

      // Update the confirmation modal's delete button's URL
      deleteForm.setAttribute('action', deleteUrl);

      // Show the confirmation modal
      confirmationModal.show();
    });
  });

  // Add event listener to confirm delete button
  confirmDeleteButton.addEventListener('click', function() {
    deleteForm.submit();
  });
</script>

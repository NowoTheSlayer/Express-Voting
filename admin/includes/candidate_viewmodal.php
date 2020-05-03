<!-- The Modal -->
<div class="modal fade" id="candidate_viewmodal_<?= $candid_id; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w-100 text-center">View Candidate</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body fa-2x">
        <div class="container">
          
        <tr>
          <td>Position : </td>
          <td><?= $res['position']; ?></td>
        </tr><br>
        
        <tr>
          <td>Firstname : </td>
          <td><?= $res['firstname']; ?></td>
        </tr><br>
        
        <tr>
          <td>stname : </td>
          <td><?= $res['lastname']; ?></td>
        </tr><br>
        
        <tr>
          <td>Level : </td>
          <td><?= $res['level']; ?></td>
        </tr><br>
        
        <tr>
          <td>Gender : </td>
          <td><?= $res['gender']; ?></td>
        </tr><br>
        
        <tr>
          <td>Image : </td>
          <td><img src="<?= $res['image']; ?>" class="img-thumbnail" style="width: 300px; height:300px;" alt="Image"></td>
        </tr><br>
        </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="candidate_updatemodal">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w-100 text-center">Update Candidate</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <label>Position:</label>
          <select id="update_position" class="custom-select">
            <option value=""></option>
            <?php
              $sql_post = "SELECT * FROM position";
              $result_post = $db->query($sql_post);
              while($cand = mysqli_fetch_assoc($result_post)):
            ?>
              <option value="<?= $cand['post']; ?>"><?= $cand['post']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="update_firstname">First Name:</label>
          <input type="text" class="form-control text-capitalize" id="update_firstname">
        </div>

        <div class="form-group">
          <label for="update_lastname">Last Name:</label>
          <input type="text" class="form-control text-capitalize" id="update_lastname">
        </div>

        <div class="form-group">
          <label>Level:</label>
          <select id="update_level" class="custom-select">
            <option value=""></option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="400">400</option>
          </select>
        </div>

        <div class="form-group">
          <label>Gender:</label>
          <select id="update_gender" class="custom-select">
            <option value=""></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <p>Custom file:</p>
        <div class="custom-file mb-3">
          <input type="file" class="custom-file-input" id="update_image">
          <label class="custom-file-label" for="update_image">Upload Image</label>
        </div>

        <button type="button" class="btn btn-block btn-primary" onclick="updateCandidate()">Save Changes</button>
        <input type="hidden" id="hidden_user_id">
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>
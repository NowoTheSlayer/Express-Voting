<!-- The Modal -->
<div class="modal fade" id="voter_addmodal">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w-100 text-center">Add Voter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <div id="error_message" class="text-danger text-center"></div>

        <div class="form-group">
          <label for="voters_id">ID:</label>
          <input type="text" class="form-control" id="voters_id">
        </div>

        <div class="form-group">
          <label for="firstname">First Name:</label>
          <input type="text" class="form-control text-capitalize" id="firstname">
        </div>

        <div class="form-group">
          <label for="lastname">Last Name:</label>
          <input type="text" class="form-control text-capitalize" id="lastname">
        </div>

        <div class="form-group">
          <label for="pwd">Password:</label>
          <input type="password" class="form-control" id="pwd">
        </div>

        <div class="form-group">
          <label>Level:</label>
          <select id="level" class="custom-select">
            <option selected></option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="400">400</option>
          </select>
        </div>

        <div class="form-group">
          <label>Gender:</label>
          <select id="gender" class="custom-select">
            <option selected></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <div class="form-group">
          <label>Status:</label>
          <select id="status" class="custom-select">
            <option selected></option>
            <option value="Voted">Voted</option>
            <option value="Female">Not Voted</option>
          </select>
        </div>

        <div class="form-group">
          <label>Account:</label>
          <select id="account" class="custom-select">
            <option selected></option>
            <option value="Active">Active</option>
            <option value="Not Active">Not Active</option>
          </select>
        </div>
        
        <button type="button" class="btn btn-block btn-primary" onclick="addVoter()">Add</button>
        <input type="hidden" id="hidden_user_id">  
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
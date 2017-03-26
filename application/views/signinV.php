
<?php $this->load->view('/templates/header'); ?>
<h1   style="text-align:center;"> Signin </h1>



<?= form_open() ?>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Your username">
        </div>
        <?php echo form_error('username'); ?>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Your password">
        </div>
        <?php echo form_error('password'); ?>
        <div class="form-group">
          <input type="submit" class="btn btn-default" value="Signin">
        </div>
      </form>

<?php /*
<div class="form-content">
        <div class="form-header background-dark-green white">
          <div class="form-top-left">
              <h3>Signin</h3>
              <p> See whats going on in your signin </p>
          </div>
          <div class="form-top-right">
              <span class="glyphicon glyphicon-lock"></span>
          </div>
          <br style="clear:both"/>
        </div>
        <div class="form-body">
      <!-- <form role="form"> -->
      <?= form_open() ?>
            <div class="form-group category">
              <label for="category"> <span class="glyphicon glyphicon-user"></span> </span> Signin as </label>
        <select  class="form-control form-element" name='category'>
          <option class='drop-down' value='student'> Student </option>      
          <option class='drop-down' value='teacher'> Teacher </option>           
          <option class='drop-down' value='administration'> Administration </option>      
        </select>
      </div>
            <div class="form-group is-hidden email">
              <label for="Email"> <span class="glyphicon glyphicon-user"> </span> Email</label>
            <input type="textbox" class="form-control form-element" name="email" placeholder="Email">
            </div>

            <div class="form-group password">
              <label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
        <input type="password" class="form-control form-element" name="password" placeholder="Password">
            </div>
            <br>
      <button type="button" class="btn btn-default btn-success btn-block submit-btn login-btn"><span class="glyphicon glyphicon-lock"></span>&nbsp; Login</button>
          </form>
        </div>
        <div class="modal-footer">
          <!-- Message from serverside (basanth)-->
          <div class="pull-left message" id="login-message"></div>
           <p>Forgot <a id="forgot-password" href="#">Password?</a></p><br>
        </div>
      </div>
      */?>

      <?php $this->load->view('/templates/footer'); ?>
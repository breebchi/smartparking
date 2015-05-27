    <div class="container">

      <?php echo $this->Form->create('User', array('action' => 'login', 'class'=>'form-signin')); ?>

        <h2 class="form-signin-heading">sign in now</h2>
        
        <?php echo $this->Session->flash(); ?>
        <div class="login-wrap">
        
        
            <div class="user-login-info">
            
             <?php echo $this->Form->input('username', array('label'=>false, 'id'=>'username', 'class'=>'form-control', 'placeholder'=>'Username', 'div'=>false, 'value'=>'')); ?>

              <?php echo $this->Form->input('password', array('label'=>false, 'id'=>'password', 'class'=>'form-control', 'placeholder'=>'Password', 'div'=>false, 'value'=>'')); ?>
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <?php echo $this->Form->button($this->Html->tag('span', __('Sign In', true)).$this->Html->tag('i', '', array('class'=>'fa fa-arrow-right')), array('type' => 'submit', 'class'=>'btn btn-primary btn-rounded btn-iconed')); ?>
          <?php echo $this->Form->end(); ?>

        </div>

         

     

    </div>
    


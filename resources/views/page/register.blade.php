<div class="register container signup" ng-controller="SignupController">
        <div class="card">
          <h1>注册</h1>
          <form ng-submit="User.signup()" name="signup_form">
              <div class="input-group">
                 <label>用户名:</label>
                 <input type="text" ng-model="User.signup_data.username" name="username" ng-minlength="4" ng-maxlength="16" ng-model-options="{debounce:500}"  required>
                 <div class="input-error-set" ng-if="signup_form.username.$touched">
                     <div ng-if="signup_form.username.$error.required">用户名为必填项</div>
                     <div ng-if="signup_form.username.$error.minlength || signup_form.username.$error.maxlength">用户名长度需在4到16位之间</div>
                     <div ng-if="User.signup_username_exists">用户名已存在</div>
                 </div>
              </div>
              <div class="input-group">
                 <label>密码:</label>
                 <input type="password" ng-model="User.signup_data.password" name="password" ng-minlength="6" ng-maxlength="25"  required>
                 <div class="input-error-set" ng-if="signup_form.password.$touched">
                     <div ng-if="signup_form.password.$error.required">密码为必填项</div>
                     <div ng-if="signup_form.password.$error.minlength || signup_form.password.$error.maxlength">密码长度需在4到25位之间</div>
                 </div>
              </div>
              
              <button type="submit"  class="primary" ng-disabled="signup_form.$invalid">注册</button>
          </form>
        </div>
    </div>
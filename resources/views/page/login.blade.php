<div class="login container signin" ng-controller="SigninController">
        <div class="card">
          <h1>登录</h1>
          <form ng-submit="User.signin()" name="signin_form">
              <div class="input-group">
                 <label>用户名:</label>
                 <input type="text" ng-model="User.signin_data.username" name="username"  required>
              </div>
              <div class="input-group">
                 <label>密码:</label>
                 <input type="password" ng-model="User.signin_data.password" name="password"  required>
                 <div class="input-error-set" ng-if="User.signin_failed">
                     用户名或密码错误
                 </div>
              </div>
              
              <button type="submit" class="primary" ng-disabled="signin_form.username.$error.required || signin_form.password.$error.required">登录</button>
          </form>
        </div>
    </div>
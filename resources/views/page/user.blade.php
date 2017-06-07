<div class='home container' style='padding-top:20px;' ng-controller='UserController'>
  <div class='left_content'>
    <h1>用户信息</h1>
    <div class='hr'></div>
    <h2>用户提问</h2>
    <div class='item-set'>
      <div ng-repeat="(key, value) in User.his_questions">
        [: value.title :]
     </div>
     <div class='hr'></div>
     <h2>用户回答</h2>
     <div ng-repeat="(key, value) in User.his_answers">
        [: value.content :]
     </div>
      
    </div>
  </div>
  <div class='right_content'>
    <h1>用户详情</h1>
    <div class="hr"></div>
    <div>用户名</div>
    <div>[: User.self_data.username :]</div>
    <div>简介</div>
    <div>[: User.self_data.intro :]</div>
  </div>
</div>

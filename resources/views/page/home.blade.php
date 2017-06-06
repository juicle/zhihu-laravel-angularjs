
      <div class="home container" style="padding-top:20px;"  ng-controller="HomeController"> 
         <div class="left_content">
             <h1>最新动态</h1>
         <div class="hr"></div>
         <div class="item-set">

            <div class="feed item clearfix" ng-repeat="item in TimeLine.data">
              <div class="vote" ng-if="item.question_id">
                  <div class="up" ng-click="TimeLine.vote({id:item.id, vote:1})">赞[: item.upvote_count :]</div>
                  <div class="down" ng-click="TimeLine.vote({id:item.id, vote:2})">踩[: item.downvote_count :]</div>
              </div>
              <div class="feed-item-content">
                  <div class="content-act" ng-if="item.question_id">[: item.users[0].username :]添加了回答</div>
                  <div class="content-act" ng-if="!item.question_id">[: item.user.username :]添加了提问</div>
                  <div class="title">[: item.title :]</div>
                  <div class="contet-owner">[: item.user.username :]<span class="desc"> 一个爱吃爱玩的科学家 (๑•̀ㅂ</span></div>
                  <div class="content-main"> [: item.content :]
                  </div>
                  <div class="action-set">
                    <div class="comment">
                    评论
                    </div>  
                  </div>
                  
                  <div class="comment-block">
                      <div class="comment-item-set">
                          <div class="rect"></div>
                          <div class="comment-item clearfix">
                             <div class="user">
                                 腐国的兔兔
                             </div> 
                             <div class="comment-content">
                                 在牛津，中餐馆一顿大概一人20-30镑，西餐厅一顿brunch大概8镑，西餐厅午晚饭大概15-20镑一人。我们学院早饭1.5镑左右，午饭2.5镑左右，晚饭4镑。Formal dinner根据学院不同在2.5-12镑之间，guest night根据学院的不同在8-20镑之间。我们学院guest night最贵14.5镑。在英国这么高消费的地方，学院的饭已经很便宜了。
                             </div> 
                          </div>
                          <div class="hr"></div>
                          <div class="comment-item clearfix">
                             <div class="user">
                                 腐国的兔兔
                             </div> 
                             <div class="comment-content">
                                 在牛津，中餐馆一顿大概一人20-30镑，西餐厅一顿brunch大概8镑，西餐厅午晚饭大概15-20镑一人。我们学院早饭1.5镑左右，午饭2.5镑左右，晚饭4镑。Formal dinner根据学院不同在2.5-12镑之间，guest night根据学院的不同在8-20镑之间。我们学院guest night最贵14.5镑。在英国这么高消费的地方，学院的饭已经很便宜了。
                             </div> 
                          </div>

                      </div>
                  </div>
                  
              </div>
              <div class="hr"></div>
            </div>
            <div class="tac" ng-if="TimeLine.pedding">加载中...</div>
            <div class="tac" ng-if="TimeLine.nomoredata">没有更多数据了</div>
            

            
         </div>
         </div>
         <div class="right_content">
             ad
         </div>
         
      </div>
 
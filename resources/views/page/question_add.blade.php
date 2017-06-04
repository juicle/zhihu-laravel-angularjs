<div class="question_add container" ng-controller="QuestionController">
        <div class="card">
            <form ng-submit="Question.addQuestion()" name="questionadd">
                <div class="input-group">
                  <label>问题标题</label>
                  <input type="text" name="title" ng-model="Question.new_question.title" ng-minlength="5" ng-maxlength="255" required>
                </div>
                <div class="input-group">
                  <label>问题描述</label>
                  <textarea name="desc" ng-model="Question.new_question.desc"></textarea>
                </div>
                <div class="input-group">
                  <button type="submit" ng-disabled="questionadd.$invalid" class="primary">提交</button>
                </div>
            </form>
        </div>
    </div>
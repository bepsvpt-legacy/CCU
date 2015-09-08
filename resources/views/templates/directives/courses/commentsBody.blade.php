<h4 ng-class="(comment.anonymous) ? 'text-muted' : 'text-info'" class="media-heading">@{{ (comment.anonymous) ? '匿名' : comment.user.nickname }}</h4>

<p class="courses-comments-content">@{{ comment.content }}</p>

<div>
    <small>
        <div ng-if="$root.user.signIn && undefined === action" class="inline">
            <div ng-if="-1 !== (index = vote.findIndex(comment.id))" class="inline">
                <span ng-click="vote.voteWithdraw(comment, vote.votes[index].agree)" class="text-primary cursor-pointer">@{{ vote.votes[index].agree ? '收回讚' : '收回爛' }}</span>
                <action-separation></action-separation>
            </div>
            <div ng-if="-1 === index" class="inline">
                <span ng-click="vote.voteComment(comment, true)" class="text-primary cursor-pointer">讚</span>
                <action-separation></action-separation>
                <span ng-click="vote.voteComment(comment, false)" class="text-primary cursor-pointer">爛</span>
                <action-separation></action-separation>
            </div>
        </div>
        <span class="text-success"><span class="fa fa-thumbs-o-up"></span> <span>@{{ comment.agree }}</span></span>
        <action-separation></action-separation>
        <span class="text-danger"><span class="fa fa-thumbs-o-down"></span> <span>@{{ comment.disagree }}</span></span>
        <action-separation></action-separation>
        <span data-toggle="tooltip" data-placement="bottom" title="@{{ comment.posted_at.date }}">@{{ comment.posted_at.human }}</span>
    </small>
</div>
webpackJsonp([2],{"96oG":function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"flex flex-row relative"},[n("div",{staticClass:"text-gray-500 text-center flex-none github-activity-icon",class:t.icon,staticStyle:{width:"2rem","font-size":"22px"}}),t._v(" "),n("div",{staticClass:"pl-4 flex-grow relative"},[n("p",{staticClass:"text-gray-500"},[t._v("\n      about "+t._s(t.formattedDate)+"\n    ")]),t._v(" "),n("p",{staticClass:"font-white mt-1 text-sm"},[n("strong",[n("a",{attrs:{href:t.profileUrl,target:"_blank"}},[t._v("\n          "+t._s(t.event.actor.display_login)+"\n        ")]),t._v("\n\n        "+t._s(t.action)+"\n\n        "),n("a",{staticClass:"text-sea-green-500",attrs:{href:t.event.payload.pull_request.html_url,target:"_blank"}},[t._v("\n          "+t._s(t.pullRequestNumberString)+"\n        ")]),t._v("\n\n        "+t._s(t.preposition)+"\n\n        "),n("a",{attrs:{href:t.repoUrl,target:"_blank"}},[t._v("\n          "+t._s(t.event.repo.name)+"\n        ")])])]),t._v(" "),n("p",{staticClass:"font-gray-500 align-middle mt-2"},[n("a",{attrs:{href:t.event.payload.pull_request.user.html_url}},[n("img",{staticClass:"inline align-bottom",attrs:{width:"18",height:"18",src:t.event.payload.pull_request.user.avatar_url}})]),t._v("\n\n      "+t._s(t.event.payload.pull_request.title)+"\n    ")])])])},staticRenderFns:[]}},A1bc:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("pRWI");e.default={name:"git-hub-pull-request-event",mixins:[a.a],data:function(){return{icon:"fas fa-file-upload",action:"opened",preposition:"at"}},computed:{profileUrl:function(){return"".concat(this.baseLink,"/").concat(this.event.actor.login)},repoUrl:function(){return"".concat(this.baseLink,"/").concat(this.event.repo.name)},pullRequestNumberString:function(){return"Pull Request #".concat(this.event.payload.pull_request.number)}},mounted:function(){switch(this.action=this.event.payload.action,this.event.payload.action){case"assigned":case"review_requested":case"review_request_removed":case"labeled":case"unlabeled":case"edited":break;case"closed":this.event.payload.merged?(this.action="merged",this.icon="fas fa-download"):this.icon="fas fa-minus-circle"}}}},gbjC:function(t,e,n){var a=n("VU/8")(n("A1bc"),n("96oG"),!1,null,null,null);t.exports=a.exports},pRWI:function(t,e,n){"use strict";var a=n("PJh5"),r=n.n(a),s=n("ycsb"),i=n.n(s);e.a={name:"git-hub-activity-mixin",components:{Card:i.a},props:{event:Object},data:function(){return{baseLink:"https://github.com",tmpAvatarUrl:"https://pbs.twimg.com/profile_images/936031034168172545/TwJzUf5p_normal.jpg"}},computed:{formattedDate:function(){return r()(this.event.created_at).fromNow()},profileUrl:function(){return"".concat(this.baseLink,"/").concat(this.event.actor.login)},repoUrl:function(){return"".concat(this.baseLink,"/").concat(this.event.repo.name)},branchName:function(){return this.event.payload.ref.replace("refs/heads/","")},branchUrl:function(){return"".concat(this.repoUrl,"/tree/").concat(this.branchName)},branchCommitsUrl:function(){return"".concat(this.repoUrl,"/commits/").concat(this.branchName)},displayCommits:function(){var t=this.event.payload.commits;return t.length>4?t.slice(0,4):t},extraCommitsCount:function(){var t=this.event.payload.commits;return t.length>4?t.length-4:0},issueNumberString:function(){return"Issue #".concat(this.event.payload.issue.number)},issueComment:function(){var t=this.event.payload.comment.body;return t.length>280?t.slice(0,280).slice(0,t.lastIndexOf(" "))+"...":t}},methods:{shortMsg:function(t){var e=t.indexOf("\n");return e>=0?t.slice(0,e):t},shortHash:function(t){return t.slice(0,6)},commitUrl:function(t){return"".concat(this.repoUrl,"/commit/").concat(t)}}}}});
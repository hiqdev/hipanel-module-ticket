# hiqdev/hipanel-module-ticket

## [Under development]

    - [cfb3b38] 2017-06-20 renamed `web` config <- hisite [@hiqsol]
    - [15e696a] 2017-06-20 renamed `hidev.yml` [@hiqsol]
    - [b272278] 2017-06-14 Added status display in tickets [@tafid]
    - [b3e3e24] 2017-05-03 Merge pull request #1 from bladeroot/ticket-templates-form [@SilverFire]
    - [16ebc98] 2017-05-03 fix form templates: delete unnecessary '?>' [@BladeRoot]
    - [5c951db] 2017-04-19 Made a FAQ menu item is visible [@tafid]
    - [1c04a51] 2017-04-13 Added hiqdev/hipanel-faq require to composer [@tafid]
    - [cc71087] 2017-04-13 Ticket view - client info block load is asuncronous [@SilverFire]
    - [ba9b56f] 2017-04-12 Renamed Tickets to Help. Moved it down, after all menu items [@tafid]
    - [a87b394] 2017-04-12 Removed set-orientation action [@tafid]
    - [a732b92] 2017-02-24 Hid is_private from users, other minor fixes [@SilverFire]
    - [3e04111] 2017-02-15 Fixed TemplatesWidget to follow Combo API changes; [@SilverFire]
    - [d7bec02] 2017-02-14 Updated TemplatesWidget to use cache->getOrSet instead of getAuthTimeCached [@SilverFire]
    - [b7b5615] 2017-02-10 Updated TemplateCombo and views to follow yii2-combo API changes [@SilverFire]
    - [740bfbe] 2017-02-02 fixed typo in 5cbd1d2d [@hiqsol]
    - [1a86bae] 2017-01-31 chkipper inited [@SilverFire]
    - [5cbd1d2] 2017-01-31 csfixed [@SilverFire]
    - [27bc95b] 2017-01-31 Added tickets index page auto-updating [@SilverFire]
    - [6c0fb38] 2017-01-31 renamed scenarioActions <- scenarioCommands [@hiqsol]
    - [39a64be] 2017-01-30 renamed hiqdev\\hiart\\ResponseErrorException <- ErrorResponseException [@hiqsol]
    - [8d78f6b] 2017-01-27 renamed from -> `tableName` in ActiveRecord [@hiqsol]
    - [e5cfcd8] 2017-01-27 changed index/type -> `from` in ActiveRecord [@hiqsol]
    - [3468141] 2017-01-26 Fixed empty text message for xeditable widget [@tafid]
    - [de17d6f] 2017-01-24 fixed hiart `perform()` usage [@hiqsol]
    - [e5180cd] 2016-12-26 Fixed orientation switch [@tafid]
    - [6e6ab61] 2016-12-22 redone yii2-thememanager -> yii2-menus [@hiqsol]
    - [43c43dd] 2016-12-21 redone Menus: widget instead of create+render [@hiqsol]
    - [10ed465] 2016-12-21 moved menus definitions to DI [@hiqsol]
    - [3c30a29] 2016-12-20 Code reformatted, used ClientSellerLink widget [@SilverFire]
    - [373f9f9] 2016-12-14 used can support instead of manage when showing answer ip [@hiqsol]
    - [963f61c] 2016-12-14 Fixed template combo init in modal [@tafid]
    - [ea1af0a] 2016-12-09 removed 1999 xmlns [@hiqsol]
    - [8e91492] 2016-12-09 csfixed [@hiqsol]
    - [f39b986] 2016-12-09 used client messengers column [@hiqsol]
    - [27e6e73] 2016-12-09 Showed country if can manage [@tafid]
    - [8e660e2] 2016-12-08 Hid IP from answer if not can manage [@tafid]
    - [eb74409] 2016-12-08 Showed client Messengers in clint block [@tafid]
    - [69857dd] 2016-12-08 Added with contacts query [@tafid]
    - [92290b1] 2016-12-07 Hid block Client if can not support and not recipient [@tafid]
    - [7ef3a3d] 2016-12-06 Hide `priority` attribute form client [@tafid]
    - [f7f941e] 2016-12-06 Hid serach fields from client [@tafid]
    - [9c94d9b] 2016-12-02 + `getClient/_id` to Thread and Answer models [@hiqsol]
    - [0ab0a74] 2016-11-29 Added new menu to Tickets [@tafid]
    - [df86b28] 2016-11-29 Added new Menu to Templates [@tafid]
    - [93bb503] 2016-11-18 Transfered empty alt to user gravatar image [@tafid]
    - [0c2f7e6] 2016-11-18 Added GeoIP country finding by IP [@tafid]
    - [c26ae6c] 2016-11-18 Added composer require GeoIP [@tafid]
    - [6756c08] 2016-11-17 Added title for answers count label [@SilverFire]
    - [8ebc7e0] 2016-11-17 Added alt for user avatar [@SilverFire]
    - [ab50eea] 2016-11-15 redone translation category to `hipanel:client` <- hipanel/client [@hiqsol]
    - [f7b3cad] 2016-11-14 redone translation category to `hipanel:client` <- hipanel/client [@hiqsol]
    - [8dd2937] 2016-11-12 redone translation category to hipanel:ticket [@hiqsol]
    - [2e1d7c4] 2016-11-01 - actions column in ticket index [@hiqsol]
    - [53e2935] 2016-11-01 fixed date format for DatePicker [@hiqsol]
    - [4c5a659] 2016-10-28 Change ticket subject column, remove Fa state element [@tafid]
    - [bc04a2e] 2016-10-24 translation [@tafid]
    - [4635935] 2016-10-17 `toggleButton` configuratin of Reminder was moved to the widget - removing from view [@SilverFire]
    - [9e64126] 2016-10-15 Fixed namespace for ReminderButton [@SilverFire]
    - [4c53b14] 2016-09-22 redone menu to new style [@hiqsol]
    - [c554993] 2016-09-22 removed unused hidev config [@hiqsol]
    - [7a5d054] 2016-09-22 removed old junk Plugin.php [@hiqsol]
    - [3a0d0f5] 2016-08-24 redone subtitle to original Yii style [@hiqsol]
    - [0db1622] 2016-08-23 redone breadcrumbs to original Yii style [@hiqsol]
    - [13e5f58] 2016-07-28 fixed translations: app -> hipanel [@hiqsol]
    - [3763603] 2016-08-01 Added IP and Country name display in ticket answers [@tafid]
    - [6f83f8b] 2016-07-22 Added to button btn-sm class on the ticket view page [@tafid]
    - [d61e57e] 2016-07-22 Removed reminder action from grid [@tafid]
    - [b3054fd] 2016-07-22 Added ReminderButton to ticket view [@tafid]
    - [c77d6ae] 2016-07-22 Added reminder button to action [@tafid]
    - [251bb77] 2016-07-21 Relocate Reminder to core [@tafid]
    - [82de77a] 2016-07-20 Removed TicketController::actionFileView as unused [@SilverFire]
    - [d228632] 2016-07-20 Refactored comment attachments display [@SilverFire]
    - [35e752e] 2016-07-20 Thread::getAnswers() - added join for files, updatef File behavior [@SilverFire]
    - [2989f7e] 2016-07-20 Answer model - added Files relation [@SilverFire]
    - [75747cc] 2016-07-20 Added new file for Reminder functionality [@tafid]
    - [37098b4] 2016-07-17 Translations updated [@SilverFire]
    - [ef94fc0] 2016-07-14 Fixed ticket subscribe button [@SilverFire]
    - [8e5980a] 2016-07-08 used hipanel Markdown [@hiqsol]
    - [8779a93] 2016-07-08 used hipanel Markdown [@hiqsol]
    - [91c2764] 2016-07-08 Add MainColumn to name attribute for index grid in TemplateGridView [@tafid]
    - [4b20497] 2016-07-06 more improving ticket title rendering [@hiqsol]
    - [182bca9] 2016-07-06 improved ticket title rendering [@hiqsol]
    - [2281483] 2016-07-04 csfixed [@hiqsol]
    - [ce979bf] 2016-07-04 csfixed className() -> class [@hiqsol]
    - [a9353ab] 2016-07-01 removed default ticket type at ticket create [@hiqsol]
    - [e2a31ed] 2016-06-28 Fixed servers count display [@SilverFire]
    - [236d994] 2016-06-27 Implemented ticket answer templates [@SilverFire]
    - [090f3dd] 2016-06-27 Updated translations [@SilverFire]
    - [d123dbc] 2016-06-24 Removed pagination in ticket/templates action [@SilverFire]
    - [7e002bb] 2016-06-24 Implemented templates for tickets [@SilverFire]
    - [3d00ced] 2016-06-24 Updated translations [@SilverFire]
    - [63ab7f2] 2016-06-23 CSS fix TicketGridView, answer_count nowrap [@tafid]
    - [9744a3d] 2016-06-22 Fix design Create button [@tafid]
    - [641992c] 2016-06-21 Removed commented code [@SilverFire]
    - [c952a58] 2016-06-18 Updated translations [@SilverFire]
    - [4cccada] 2016-06-16 Changed Ref::getList to $this->getRefs in controllers, changed Ref::getList calling signature fo follow mmethod changes, other minors [@SilverFire]
    - [e8b73bd] 2016-06-16 Updated translations [@SilverFire]
    - [76093db] 2016-06-16 csfixed: renamed templates to camel case [@hiqsol]
    - [e096222] 2016-06-16 csfixed [@hiqsol]
    - [a1500a4] 2016-06-16 fixed dependencies [@hiqsol]
    - [0d51a48] 2016-06-16 allowed build failure for PHP 5.5 [@hiqsol]
    - [0bf4983] 2016-06-16 Updated work with translations [@SilverFire]
    - [8d09755] 2016-06-16 Fixed "Create ticket" button layout [@SilverFire]
    - [424c6ac] 2016-06-15 Fixed textarea autofocus on ticket create page [@SilverFire]
    - [0e7facb] 2016-06-15 tidying up kartik widgets [@hiqsol]
    - [5e8f83f] 2016-05-31 Change index layout [@tafid]
    - [4b79a12] 2016-05-20 Ticket/view - Used withDomains and withServers [@SilverFire]
    - [22d6fc2] 2016-05-19 fixed broken namespaces [@hiqsol]
    - [ac577a5] 2016-05-18 fixed composer.json [@hiqsol]
    - [c3051a3] 2016-05-18 used composer-config-plugin [@hiqsol]
    - [d9d7e3e] 2016-04-29 Updated threadChecker to use Visibilityjs plugiin [@SilverFire]
    - [d58ec64] 2016-04-27 Added auto-refreshing of comments in the thread [@SilverFire]
    - [dad65ee] 2016-04-27 Added threadChecker asset [@SilverFire]
    - [d755715] 2016-04-26 fixed anonymous ticket display [@SilverFire]
    - [772d75b] 2016-04-25 Minor [@SilverFire]
    - [74214d1] 2016-04-22 Updated update-answer-modal action to use PrepareAjaxViewAction [@SilverFire]
    - [724c2f5] 2016-04-22 Ticket views mass refactoring in order to satisfy previous changes is module [@SilverFire]
    - [dc0ceb5] 2016-04-22 Added answer update modal view [@SilverFire]
    - [28b0543] 2016-04-22 Added ConditionalFormWidget [@SilverFire]
    - [cc0974c] 2016-04-22 Removed unused methods in Thread model [@SilverFire]
    - [9bb4a63] 2016-04-22 Added @ticket/answer alias [@SilverFire]
    - [efae406] 2016-04-22 Added AnswerController [@SilverFire]
    - [f83f183] 2016-04-22 Thread model refactored. Removed unused method and attribues, added getAnswer relation Added Answer model [@SilverFire]
    - [89e5dee] 2016-04-22 Added TicketController::updateAnswerModal action, viewAction updated to join answers relation [@SilverFire]
    - [c7a1ac5] 2016-04-22 Updated messages [@SilverFire]
    - [5bac650] 2016-04-21 Update Ticket::actionView in order to show client's domains and servers on the ticket details page [@SilverFire]
    - [932ae2b] 2016-04-17 Removed `Reply` button under each comment [@SilverFire]
    - [eb9cbba] 2016-04-01 Add lastAnswer to grid [@tafid]
- Fixed Travis build
    - [5493c40] 2016-03-31 phpcsfixed [@hiqsol]
    - [2c48fb3] 2016-03-31 inited tests [@hiqsol]
    - [ed8074e] 2016-03-31 rehideved [@hiqsol]
    - [b58e91d] 2016-03-31 fixed travis build with `hiqdev/composer-asset-plugin` [@hiqsol]
- Fixed translation and minor issues
    - [421ddc2] 2016-03-29 Add LastAnswer [@tafid]
    - [acabfa2] 2016-03-29 Added answer button to the botton of the view page [@SilverFire]
    - [bb9ff7f] 2016-03-28 Fixed ticket subsribtion/unsubscription when ticket is closed [@SilverFire]
    - [861d98e] 2016-03-26 Translations updated [@SilverFire]
    - [6c0d614] 2016-03-18 Fixed subsribe/unsubscribe button [@SilverFire]
    - [b97b90e] 2016-03-16 Added module-scope translations Ticket view - changed client info block to recepient date Other minor enh/fixes [@SilverFire]
    - [0e2e475] 2016-03-16 Added missing translation [@SilverFire]
    - [31e1509] 2016-02-02 Fixed standalone action to use updated api [@tafid]
    - [e84ade9] 2016-02-02 Fix visibility spen and `answer_spent` [@tafid]
    - [5a9e949] 2016-01-18 Add subject and messgae search [@tafid]
    - [f2c962a] 2015-12-30 Reformat html in `_search` [andreyklochok@gmial.com]
    - [fb35545] 2015-12-17 Add OcticonsAsset, change markdown icon [@tafid]
    - [5ffe7e1] 2015-12-17 Register OcticonsAsset in `_form` [@tafid]
    - [de570b3] 2015-12-09 Removed PHP short-tags [@SilverFire]
    - [0766630] 2015-12-04 Classes notation changed from pathtoClassName to PHP 5.6 ClassName::class [@SilverFire]
    - [eabf9a5] 2015-11-27 Add link to answer [@tafid]
    - [78edf71] 2015-11-26 Fix js [@tafid]
    - [e7597ca] 2015-11-26 When isNewRecord the form is visible [@tafid]
    - [9807bb9] 2015-11-26 Change Save button color, remove from SidebarMenu Ticket Settings item [@tafid]
    - [be9a2bb] 2015-11-09 Removed options of Kartik\GridView [@SilverFire]
    - [5063858] 2015-08-03 \Merge branch 'master' of git://github.com/hiqdev/hipanel-module-ticket [@tafid]
    - [6e41d49] 2015-10-12 Added `new_messages_first` setting [@SilverFire]
    - [6094f65] 2015-10-08 Ticket advanced serach - DatePicker call optimized [@SilverFire]
    - [d7413da] 2015-10-07 Added getResponsibleClientTypes() to Thread model [@SilverFire]
    - [4c84b67] 2015-09-25 used gravatar properly [@hiqsol]
    - [9e909ae] 2015-09-24 + add language variants [@BladeRoot]
    - [b578d04] 2015-09-24 translation and minor issues [@hiqsol]
    - [90c8636] 2015-09-24 used default Client credit column [@hiqsol]
    - [de64750] 2015-09-24 ClientGridView become responsive in `_leftBlock` [@tafid]
    - [6070ac5] 2015-09-24 Fix Submit button wich overlay to `spent_time` field [@tafid]
    - [1d2610f] 2015-09-23 got rid of old common\components\Lang [@hiqsol]
    - [c0f6e87] 2015-09-21 got rid of Lang::t [@hiqsol]
    - [a7ee615] 2015-09-17 * improve language pack [@BladeRoot]
    - [5297f20] 2015-09-15 localized menu [@hiqsol]
    - [74f0e4d] 2015-08-28 Added dependencies on related projects [@SilverFire]
    - [b949ce6] 2015-08-31 XEditble functionality [@tafid]
    - [e753231] 2015-08-31 fixed showing closed ticket details [@hiqsol]
    - [5025abe] 2015-08-28 Watchers can change only support [@tafid]
    - [10fc4a7] 2015-08-28 Some design fixes [@tafid]
    - [14f4147] 2015-08-27 Resonsible view fix [@tafid]
    - [09d149f] 2015-08-27 Fix [@tafid]
    - [0013006] 2015-08-27 fixed column labels at ticket index [@hiqsol]
    - [355ab0c] 2015-08-27 Fixed breadcrumbs subtitle [@SilverFire]
    - [a79acc0] 2015-08-27 Fixed deprecated method calling syntax [@SilverFire]
    - [b784b25] 2015-08-26 Remove statistic from menu [@tafid]
    - [7bdaf68] 2015-08-25 Modifications to implement ErrorResponseException [@SilverFire]
    - [21bb09c] 2015-08-25 Fix warnings [@tafid]
    - [5a0a8ba] 2015-08-22 + info color for VDS topic [@hiqsol]
- Fixed ticket details page
    - [fc14599] 2015-09-23 improved usage of Gravatar [@hiqsol]
    - [89f228e] 2015-09-18 Add close link on the index page [@tafid]
    - [6534141] 2015-09-16 fixed anonym displaying [@hiqsol]
    - [3c20ad8] 2015-09-09 Add autosize method [@tafid]
    - [dd6869b] 2015-09-10 + conditional domains count [@hiqsol]
    - [c423552] 2015-09-08 Minify time input [@tafid]
    - [5367262] 2015-09-08 Add watchers input in create ticket action [@tafid]
    - [7c2c8b0] 2015-09-08 Fix spent time display [@tafid]
    - [b2a2ab6] 2015-09-07 Change attribute name from `spent_mintue` to spent in view file [@tafid]
    - [6fe1530] 2015-09-07 Fix spent time [@tafid]
    - [d8a14cf] 2015-09-07 Change topic view [@tafid]
    - [e60da36] 2015-09-07 Ticket detail view - added duration formatting [@SilverFire]
    - [bb7f974] 2015-09-04 Responsible fix [@tafid]
    - [ff82588] 2015-09-03 TicketView - implemented asignee xeditable [@SilverFire]
    - [42162eb] 2015-09-03 Add default value for responsible [@tafid]
    - [6f305ac] 2015-09-02 Disable watchers editable [@tafid]
    - [4ab6354] 2015-09-02 Add one more field [@tafid]
    - [6430696] 2015-09-02 Some fixes [@tafid]
    - [9b291e8] 2015-09-02 View pagee - ticket watchers implemented with ComboXeditable [@SilverFire]
    - [d0c8914] 2015-09-02 Fix topics when ticket create, fix close/open button [@tafid]
    - [d989f8e] 2015-09-01 State functionality [@tafid]
- Added user specific index: hidden certain columns
    - [b826271] 2015-08-21 Add conditional visibility to some column [@tafid]
    - [c674569] 2015-08-21 Reformat ticket index [@tafid]
- Fixed markdown supported badge
    - [d34ca62] 2015-08-18 fixed markdown supported badge [@hiqsol]
- Fixed: hidden subscribeButton on ticket create
    - [62c3238] 2015-08-17 Hide subscribeButto on ticket create [@tafid]
- Fixed HTML issues
    - [4d7ea1c] 2015-08-12 Check and fix problem in the Ticket module [@tafid]
    - [1d142f9] 2015-08-12 Remove unnecessary gap between action button at index page [@tafid]
- Added PJAX for un/subscribe button
    - [da5ea99] 2015-08-07 Fixed (un)subsribe actions in `TicketController` [@SilverFire]
    - [53362c3] 2015-08-07 Pjax (un)subscribe button implemented [@SilverFire]
    - [50ee87e] 2015-08-07 --amend [silverfire@advancedhosters.com]
    - [6d12ddf] 2015-08-07 Implementing PJAX (un)sunscribe button [silverfire@advancedhosters.com]
- Changed: redone to smart actions
    - [401b4dc] 2015-08-06 redoing to smart actions: Subscribe/Unsubscribe, Close/Open [@hiqsol]
    - [9f428b7] 2015-08-06 minort [@hiqsol]
- Changed to all new features: ActionBox, higrid, smart actions
    - [6368ef2] 2015-08-06 unified view and create into `_view` [@hiqsol]
    - [f4d44d6] 2015-08-06 doing smart actions [@hiqsol]
    - [62de535] 2015-08-05 + show servers/domains/hosting at ticket details [@hiqsol]
    - [a589be9] 2015-08-04 redoing to smart actions [@hiqsol]
    - [0095fdf] 2015-08-04 redoing index and view for tickets with new features: ActionBox, higrid, smart actions, ... [@hiqsol]
    - [293e5be] 2015-08-04 moved avatar to main column [@hiqsol]
    - [3701269] 2015-08-04 Fix css top-padding [@tafid]
    - [4021563] 2015-08-04 fixed typo qute -> quote [@hiqsol]
- Changed code style: hideved, moved to src and php-cs-fixed
    - [e6c5ed8] 2015-08-03 php-cs-fixed [@hiqsol]
    - [7b2f876] 2015-08-03 php-cs-fixed [@hiqsol]
    - [665d514] 2015-08-03 moved to src [@hiqsol]
    - [6549eea] 2015-08-03 hideved [@hiqsol]
- Added basic functionality
    - [752bd0e] 2015-08-03 Bulk buttons change [@tafid]
    - [12aeebe] 2015-08-02 * Plugin: + aliases [@hiqsol]
    - [88bd1e8] 2015-07-31 checkboxes moved left [@hiqsol]
    - [a0ab6ff] 2015-07-31 Relocate SortLink widget [@tafid]
    - [4c5c554] 2015-07-31 Conflict [@tafid]
    - [4e71276] 2015-07-31 Redisign Sort on index page [@tafid]
    - [d5cba10] 2015-07-31 redone searchModel -> model in index action [@hiqsol]
    - [a01d0fc] 2015-07-24 Remove comment code [@tafid]
    - [c7d62db] 2015-07-17 Remove Select2 widget use [@tafid]
    - [be49af9] 2015-06-03 Fix. Remove VarDump\ [@tafid]
    - [b1f31e0] 2015-05-25 renamed hiart [@hiqsol]
    - [44ee07b] 2015-05-24 used asset packages [@hiqsol]
    - [5949337] 2015-05-22 combo - updated parent namespace [@SilverFire]
    - [f1c35f1] 2015-05-22 Remove all exctra icons from SidebarMenu [@tafid]
    - [250d0d1] 2015-05-21 Some Combo fix [@tafid]
    - [510d92a] 2015-05-20 Fix Subscribe button [@tafid]
    - [b6982e0] 2015-05-20 ... [@tafid]
    - [e693b42] 2015-05-19 Combo for GridView filter, process [@tafid]
    - [df52073] 2015-05-19 Fix `_search` file, select2 -> combo [@tafid]
    - [f41eb95] 2015-05-19 Fix watchers field [@tafid]
    - [dd2f617] 2015-05-15 Combo calls modified [@SilverFire]
    - [6a080a9] 2015-05-15 + Plugin, * Menu [@hiqsol]
    - [3f48f73] 2015-05-15 fix [@tafid]
    - [dc4eee5] 2015-05-15 some fix [@tafid]
    - [bbb15c4] 2015-05-15 StaticCombo call update [@SilverFire]
    - [523831b] 2015-05-14 + Menu.php [@hiqsol]
    - [a452070] 2015-05-14 Combo2 ~> combo, fixing calls [@SilverFire]
    - [7091a12] 2015-05-14 Fix translation TicketController [@tafid]
    - [2b92b5f] 2015-05-14 Sort and wathers [@tafid]
    - [263e914] 2015-05-13 Change select2 to combo2 [@tafid]
    - [f75846a] 2015-04-29 GitHub Markdown icon [@tafid]
    - [81f24b6] 2015-04-29 Add basic functionality [@tafid]
    - [a942e1f] 2015-04-21 inited [@hiqsol]

## [Development started] - 2015-04-21

[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[@tafid]: https://github.com/tafid
[andreyklochok@gmail.com]: https://github.com/tafid
[@BladeRoot]: https://github.com/BladeRoot
[bladeroot@gmail.com]: https://github.com/BladeRoot
[5493c40]: https://github.com/hiqdev/hipanel-module-ticket/commit/5493c40
[2c48fb3]: https://github.com/hiqdev/hipanel-module-ticket/commit/2c48fb3
[ed8074e]: https://github.com/hiqdev/hipanel-module-ticket/commit/ed8074e
[b58e91d]: https://github.com/hiqdev/hipanel-module-ticket/commit/b58e91d
[421ddc2]: https://github.com/hiqdev/hipanel-module-ticket/commit/421ddc2
[acabfa2]: https://github.com/hiqdev/hipanel-module-ticket/commit/acabfa2
[bb9ff7f]: https://github.com/hiqdev/hipanel-module-ticket/commit/bb9ff7f
[861d98e]: https://github.com/hiqdev/hipanel-module-ticket/commit/861d98e
[6c0d614]: https://github.com/hiqdev/hipanel-module-ticket/commit/6c0d614
[b97b90e]: https://github.com/hiqdev/hipanel-module-ticket/commit/b97b90e
[0e2e475]: https://github.com/hiqdev/hipanel-module-ticket/commit/0e2e475
[31e1509]: https://github.com/hiqdev/hipanel-module-ticket/commit/31e1509
[e84ade9]: https://github.com/hiqdev/hipanel-module-ticket/commit/e84ade9
[5a9e949]: https://github.com/hiqdev/hipanel-module-ticket/commit/5a9e949
[f2c962a]: https://github.com/hiqdev/hipanel-module-ticket/commit/f2c962a
[fb35545]: https://github.com/hiqdev/hipanel-module-ticket/commit/fb35545
[5ffe7e1]: https://github.com/hiqdev/hipanel-module-ticket/commit/5ffe7e1
[de570b3]: https://github.com/hiqdev/hipanel-module-ticket/commit/de570b3
[0766630]: https://github.com/hiqdev/hipanel-module-ticket/commit/0766630
[eabf9a5]: https://github.com/hiqdev/hipanel-module-ticket/commit/eabf9a5
[78edf71]: https://github.com/hiqdev/hipanel-module-ticket/commit/78edf71
[e7597ca]: https://github.com/hiqdev/hipanel-module-ticket/commit/e7597ca
[9807bb9]: https://github.com/hiqdev/hipanel-module-ticket/commit/9807bb9
[be9a2bb]: https://github.com/hiqdev/hipanel-module-ticket/commit/be9a2bb
[5063858]: https://github.com/hiqdev/hipanel-module-ticket/commit/5063858
[6e41d49]: https://github.com/hiqdev/hipanel-module-ticket/commit/6e41d49
[6094f65]: https://github.com/hiqdev/hipanel-module-ticket/commit/6094f65
[d7413da]: https://github.com/hiqdev/hipanel-module-ticket/commit/d7413da
[4c84b67]: https://github.com/hiqdev/hipanel-module-ticket/commit/4c84b67
[9e909ae]: https://github.com/hiqdev/hipanel-module-ticket/commit/9e909ae
[b578d04]: https://github.com/hiqdev/hipanel-module-ticket/commit/b578d04
[90c8636]: https://github.com/hiqdev/hipanel-module-ticket/commit/90c8636
[de64750]: https://github.com/hiqdev/hipanel-module-ticket/commit/de64750
[6070ac5]: https://github.com/hiqdev/hipanel-module-ticket/commit/6070ac5
[1d2610f]: https://github.com/hiqdev/hipanel-module-ticket/commit/1d2610f
[c0f6e87]: https://github.com/hiqdev/hipanel-module-ticket/commit/c0f6e87
[a7ee615]: https://github.com/hiqdev/hipanel-module-ticket/commit/a7ee615
[5297f20]: https://github.com/hiqdev/hipanel-module-ticket/commit/5297f20
[74f0e4d]: https://github.com/hiqdev/hipanel-module-ticket/commit/74f0e4d
[b949ce6]: https://github.com/hiqdev/hipanel-module-ticket/commit/b949ce6
[e753231]: https://github.com/hiqdev/hipanel-module-ticket/commit/e753231
[5025abe]: https://github.com/hiqdev/hipanel-module-ticket/commit/5025abe
[10fc4a7]: https://github.com/hiqdev/hipanel-module-ticket/commit/10fc4a7
[14f4147]: https://github.com/hiqdev/hipanel-module-ticket/commit/14f4147
[09d149f]: https://github.com/hiqdev/hipanel-module-ticket/commit/09d149f
[0013006]: https://github.com/hiqdev/hipanel-module-ticket/commit/0013006
[355ab0c]: https://github.com/hiqdev/hipanel-module-ticket/commit/355ab0c
[a79acc0]: https://github.com/hiqdev/hipanel-module-ticket/commit/a79acc0
[b784b25]: https://github.com/hiqdev/hipanel-module-ticket/commit/b784b25
[7bdaf68]: https://github.com/hiqdev/hipanel-module-ticket/commit/7bdaf68
[21bb09c]: https://github.com/hiqdev/hipanel-module-ticket/commit/21bb09c
[5a0a8ba]: https://github.com/hiqdev/hipanel-module-ticket/commit/5a0a8ba
[fc14599]: https://github.com/hiqdev/hipanel-module-ticket/commit/fc14599
[89f228e]: https://github.com/hiqdev/hipanel-module-ticket/commit/89f228e
[6534141]: https://github.com/hiqdev/hipanel-module-ticket/commit/6534141
[3c20ad8]: https://github.com/hiqdev/hipanel-module-ticket/commit/3c20ad8
[dd6869b]: https://github.com/hiqdev/hipanel-module-ticket/commit/dd6869b
[c423552]: https://github.com/hiqdev/hipanel-module-ticket/commit/c423552
[5367262]: https://github.com/hiqdev/hipanel-module-ticket/commit/5367262
[7c2c8b0]: https://github.com/hiqdev/hipanel-module-ticket/commit/7c2c8b0
[b2a2ab6]: https://github.com/hiqdev/hipanel-module-ticket/commit/b2a2ab6
[6fe1530]: https://github.com/hiqdev/hipanel-module-ticket/commit/6fe1530
[d8a14cf]: https://github.com/hiqdev/hipanel-module-ticket/commit/d8a14cf
[e60da36]: https://github.com/hiqdev/hipanel-module-ticket/commit/e60da36
[bb7f974]: https://github.com/hiqdev/hipanel-module-ticket/commit/bb7f974
[ff82588]: https://github.com/hiqdev/hipanel-module-ticket/commit/ff82588
[42162eb]: https://github.com/hiqdev/hipanel-module-ticket/commit/42162eb
[6f305ac]: https://github.com/hiqdev/hipanel-module-ticket/commit/6f305ac
[4ab6354]: https://github.com/hiqdev/hipanel-module-ticket/commit/4ab6354
[6430696]: https://github.com/hiqdev/hipanel-module-ticket/commit/6430696
[9b291e8]: https://github.com/hiqdev/hipanel-module-ticket/commit/9b291e8
[d0c8914]: https://github.com/hiqdev/hipanel-module-ticket/commit/d0c8914
[d989f8e]: https://github.com/hiqdev/hipanel-module-ticket/commit/d989f8e
[b826271]: https://github.com/hiqdev/hipanel-module-ticket/commit/b826271
[c674569]: https://github.com/hiqdev/hipanel-module-ticket/commit/c674569
[d34ca62]: https://github.com/hiqdev/hipanel-module-ticket/commit/d34ca62
[62c3238]: https://github.com/hiqdev/hipanel-module-ticket/commit/62c3238
[4d7ea1c]: https://github.com/hiqdev/hipanel-module-ticket/commit/4d7ea1c
[1d142f9]: https://github.com/hiqdev/hipanel-module-ticket/commit/1d142f9
[da5ea99]: https://github.com/hiqdev/hipanel-module-ticket/commit/da5ea99
[53362c3]: https://github.com/hiqdev/hipanel-module-ticket/commit/53362c3
[50ee87e]: https://github.com/hiqdev/hipanel-module-ticket/commit/50ee87e
[6d12ddf]: https://github.com/hiqdev/hipanel-module-ticket/commit/6d12ddf
[401b4dc]: https://github.com/hiqdev/hipanel-module-ticket/commit/401b4dc
[9f428b7]: https://github.com/hiqdev/hipanel-module-ticket/commit/9f428b7
[6368ef2]: https://github.com/hiqdev/hipanel-module-ticket/commit/6368ef2
[f4d44d6]: https://github.com/hiqdev/hipanel-module-ticket/commit/f4d44d6
[62de535]: https://github.com/hiqdev/hipanel-module-ticket/commit/62de535
[a589be9]: https://github.com/hiqdev/hipanel-module-ticket/commit/a589be9
[0095fdf]: https://github.com/hiqdev/hipanel-module-ticket/commit/0095fdf
[293e5be]: https://github.com/hiqdev/hipanel-module-ticket/commit/293e5be
[3701269]: https://github.com/hiqdev/hipanel-module-ticket/commit/3701269
[4021563]: https://github.com/hiqdev/hipanel-module-ticket/commit/4021563
[e6c5ed8]: https://github.com/hiqdev/hipanel-module-ticket/commit/e6c5ed8
[7b2f876]: https://github.com/hiqdev/hipanel-module-ticket/commit/7b2f876
[665d514]: https://github.com/hiqdev/hipanel-module-ticket/commit/665d514
[6549eea]: https://github.com/hiqdev/hipanel-module-ticket/commit/6549eea
[752bd0e]: https://github.com/hiqdev/hipanel-module-ticket/commit/752bd0e
[12aeebe]: https://github.com/hiqdev/hipanel-module-ticket/commit/12aeebe
[88bd1e8]: https://github.com/hiqdev/hipanel-module-ticket/commit/88bd1e8
[a0ab6ff]: https://github.com/hiqdev/hipanel-module-ticket/commit/a0ab6ff
[4c5c554]: https://github.com/hiqdev/hipanel-module-ticket/commit/4c5c554
[4e71276]: https://github.com/hiqdev/hipanel-module-ticket/commit/4e71276
[d5cba10]: https://github.com/hiqdev/hipanel-module-ticket/commit/d5cba10
[a01d0fc]: https://github.com/hiqdev/hipanel-module-ticket/commit/a01d0fc
[c7d62db]: https://github.com/hiqdev/hipanel-module-ticket/commit/c7d62db
[be49af9]: https://github.com/hiqdev/hipanel-module-ticket/commit/be49af9
[b1f31e0]: https://github.com/hiqdev/hipanel-module-ticket/commit/b1f31e0
[44ee07b]: https://github.com/hiqdev/hipanel-module-ticket/commit/44ee07b
[5949337]: https://github.com/hiqdev/hipanel-module-ticket/commit/5949337
[f1c35f1]: https://github.com/hiqdev/hipanel-module-ticket/commit/f1c35f1
[250d0d1]: https://github.com/hiqdev/hipanel-module-ticket/commit/250d0d1
[510d92a]: https://github.com/hiqdev/hipanel-module-ticket/commit/510d92a
[b6982e0]: https://github.com/hiqdev/hipanel-module-ticket/commit/b6982e0
[e693b42]: https://github.com/hiqdev/hipanel-module-ticket/commit/e693b42
[df52073]: https://github.com/hiqdev/hipanel-module-ticket/commit/df52073
[f41eb95]: https://github.com/hiqdev/hipanel-module-ticket/commit/f41eb95
[dd2f617]: https://github.com/hiqdev/hipanel-module-ticket/commit/dd2f617
[6a080a9]: https://github.com/hiqdev/hipanel-module-ticket/commit/6a080a9
[3f48f73]: https://github.com/hiqdev/hipanel-module-ticket/commit/3f48f73
[dc4eee5]: https://github.com/hiqdev/hipanel-module-ticket/commit/dc4eee5
[bbb15c4]: https://github.com/hiqdev/hipanel-module-ticket/commit/bbb15c4
[523831b]: https://github.com/hiqdev/hipanel-module-ticket/commit/523831b
[a452070]: https://github.com/hiqdev/hipanel-module-ticket/commit/a452070
[7091a12]: https://github.com/hiqdev/hipanel-module-ticket/commit/7091a12
[2b92b5f]: https://github.com/hiqdev/hipanel-module-ticket/commit/2b92b5f
[263e914]: https://github.com/hiqdev/hipanel-module-ticket/commit/263e914
[f75846a]: https://github.com/hiqdev/hipanel-module-ticket/commit/f75846a
[81f24b6]: https://github.com/hiqdev/hipanel-module-ticket/commit/81f24b6
[a942e1f]: https://github.com/hiqdev/hipanel-module-ticket/commit/a942e1f
[5cbd1d2]: https://github.com/hiqdev/hipanel-module-ticket/commit/5cbd1d2
[27bc95b]: https://github.com/hiqdev/hipanel-module-ticket/commit/27bc95b
[6c0fb38]: https://github.com/hiqdev/hipanel-module-ticket/commit/6c0fb38
[39a64be]: https://github.com/hiqdev/hipanel-module-ticket/commit/39a64be
[8d78f6b]: https://github.com/hiqdev/hipanel-module-ticket/commit/8d78f6b
[e5cfcd8]: https://github.com/hiqdev/hipanel-module-ticket/commit/e5cfcd8
[3468141]: https://github.com/hiqdev/hipanel-module-ticket/commit/3468141
[de17d6f]: https://github.com/hiqdev/hipanel-module-ticket/commit/de17d6f
[e5180cd]: https://github.com/hiqdev/hipanel-module-ticket/commit/e5180cd
[6e6ab61]: https://github.com/hiqdev/hipanel-module-ticket/commit/6e6ab61
[43c43dd]: https://github.com/hiqdev/hipanel-module-ticket/commit/43c43dd
[10ed465]: https://github.com/hiqdev/hipanel-module-ticket/commit/10ed465
[3c30a29]: https://github.com/hiqdev/hipanel-module-ticket/commit/3c30a29
[373f9f9]: https://github.com/hiqdev/hipanel-module-ticket/commit/373f9f9
[963f61c]: https://github.com/hiqdev/hipanel-module-ticket/commit/963f61c
[ea1af0a]: https://github.com/hiqdev/hipanel-module-ticket/commit/ea1af0a
[8e91492]: https://github.com/hiqdev/hipanel-module-ticket/commit/8e91492
[f39b986]: https://github.com/hiqdev/hipanel-module-ticket/commit/f39b986
[27e6e73]: https://github.com/hiqdev/hipanel-module-ticket/commit/27e6e73
[8e660e2]: https://github.com/hiqdev/hipanel-module-ticket/commit/8e660e2
[eb74409]: https://github.com/hiqdev/hipanel-module-ticket/commit/eb74409
[69857dd]: https://github.com/hiqdev/hipanel-module-ticket/commit/69857dd
[92290b1]: https://github.com/hiqdev/hipanel-module-ticket/commit/92290b1
[7ef3a3d]: https://github.com/hiqdev/hipanel-module-ticket/commit/7ef3a3d
[f7f941e]: https://github.com/hiqdev/hipanel-module-ticket/commit/f7f941e
[9c94d9b]: https://github.com/hiqdev/hipanel-module-ticket/commit/9c94d9b
[0ab0a74]: https://github.com/hiqdev/hipanel-module-ticket/commit/0ab0a74
[df86b28]: https://github.com/hiqdev/hipanel-module-ticket/commit/df86b28
[93bb503]: https://github.com/hiqdev/hipanel-module-ticket/commit/93bb503
[0c2f7e6]: https://github.com/hiqdev/hipanel-module-ticket/commit/0c2f7e6
[c26ae6c]: https://github.com/hiqdev/hipanel-module-ticket/commit/c26ae6c
[6756c08]: https://github.com/hiqdev/hipanel-module-ticket/commit/6756c08
[8ebc7e0]: https://github.com/hiqdev/hipanel-module-ticket/commit/8ebc7e0
[ab50eea]: https://github.com/hiqdev/hipanel-module-ticket/commit/ab50eea
[f7b3cad]: https://github.com/hiqdev/hipanel-module-ticket/commit/f7b3cad
[8dd2937]: https://github.com/hiqdev/hipanel-module-ticket/commit/8dd2937
[2e1d7c4]: https://github.com/hiqdev/hipanel-module-ticket/commit/2e1d7c4
[53e2935]: https://github.com/hiqdev/hipanel-module-ticket/commit/53e2935
[4c5a659]: https://github.com/hiqdev/hipanel-module-ticket/commit/4c5a659
[bc04a2e]: https://github.com/hiqdev/hipanel-module-ticket/commit/bc04a2e
[4635935]: https://github.com/hiqdev/hipanel-module-ticket/commit/4635935
[9e64126]: https://github.com/hiqdev/hipanel-module-ticket/commit/9e64126
[4c53b14]: https://github.com/hiqdev/hipanel-module-ticket/commit/4c53b14
[c554993]: https://github.com/hiqdev/hipanel-module-ticket/commit/c554993
[7a5d054]: https://github.com/hiqdev/hipanel-module-ticket/commit/7a5d054
[3a0d0f5]: https://github.com/hiqdev/hipanel-module-ticket/commit/3a0d0f5
[0db1622]: https://github.com/hiqdev/hipanel-module-ticket/commit/0db1622
[13e5f58]: https://github.com/hiqdev/hipanel-module-ticket/commit/13e5f58
[3763603]: https://github.com/hiqdev/hipanel-module-ticket/commit/3763603
[6f83f8b]: https://github.com/hiqdev/hipanel-module-ticket/commit/6f83f8b
[d61e57e]: https://github.com/hiqdev/hipanel-module-ticket/commit/d61e57e
[b3054fd]: https://github.com/hiqdev/hipanel-module-ticket/commit/b3054fd
[c77d6ae]: https://github.com/hiqdev/hipanel-module-ticket/commit/c77d6ae
[251bb77]: https://github.com/hiqdev/hipanel-module-ticket/commit/251bb77
[82de77a]: https://github.com/hiqdev/hipanel-module-ticket/commit/82de77a
[d228632]: https://github.com/hiqdev/hipanel-module-ticket/commit/d228632
[35e752e]: https://github.com/hiqdev/hipanel-module-ticket/commit/35e752e
[2989f7e]: https://github.com/hiqdev/hipanel-module-ticket/commit/2989f7e
[75747cc]: https://github.com/hiqdev/hipanel-module-ticket/commit/75747cc
[37098b4]: https://github.com/hiqdev/hipanel-module-ticket/commit/37098b4
[ef94fc0]: https://github.com/hiqdev/hipanel-module-ticket/commit/ef94fc0
[8e5980a]: https://github.com/hiqdev/hipanel-module-ticket/commit/8e5980a
[8779a93]: https://github.com/hiqdev/hipanel-module-ticket/commit/8779a93
[91c2764]: https://github.com/hiqdev/hipanel-module-ticket/commit/91c2764
[4b20497]: https://github.com/hiqdev/hipanel-module-ticket/commit/4b20497
[182bca9]: https://github.com/hiqdev/hipanel-module-ticket/commit/182bca9
[2281483]: https://github.com/hiqdev/hipanel-module-ticket/commit/2281483
[ce979bf]: https://github.com/hiqdev/hipanel-module-ticket/commit/ce979bf
[a9353ab]: https://github.com/hiqdev/hipanel-module-ticket/commit/a9353ab
[e2a31ed]: https://github.com/hiqdev/hipanel-module-ticket/commit/e2a31ed
[236d994]: https://github.com/hiqdev/hipanel-module-ticket/commit/236d994
[090f3dd]: https://github.com/hiqdev/hipanel-module-ticket/commit/090f3dd
[d123dbc]: https://github.com/hiqdev/hipanel-module-ticket/commit/d123dbc
[7e002bb]: https://github.com/hiqdev/hipanel-module-ticket/commit/7e002bb
[3d00ced]: https://github.com/hiqdev/hipanel-module-ticket/commit/3d00ced
[63ab7f2]: https://github.com/hiqdev/hipanel-module-ticket/commit/63ab7f2
[9744a3d]: https://github.com/hiqdev/hipanel-module-ticket/commit/9744a3d
[641992c]: https://github.com/hiqdev/hipanel-module-ticket/commit/641992c
[c952a58]: https://github.com/hiqdev/hipanel-module-ticket/commit/c952a58
[4cccada]: https://github.com/hiqdev/hipanel-module-ticket/commit/4cccada
[e8b73bd]: https://github.com/hiqdev/hipanel-module-ticket/commit/e8b73bd
[76093db]: https://github.com/hiqdev/hipanel-module-ticket/commit/76093db
[e096222]: https://github.com/hiqdev/hipanel-module-ticket/commit/e096222
[a1500a4]: https://github.com/hiqdev/hipanel-module-ticket/commit/a1500a4
[0d51a48]: https://github.com/hiqdev/hipanel-module-ticket/commit/0d51a48
[0bf4983]: https://github.com/hiqdev/hipanel-module-ticket/commit/0bf4983
[8d09755]: https://github.com/hiqdev/hipanel-module-ticket/commit/8d09755
[424c6ac]: https://github.com/hiqdev/hipanel-module-ticket/commit/424c6ac
[0e7facb]: https://github.com/hiqdev/hipanel-module-ticket/commit/0e7facb
[5e8f83f]: https://github.com/hiqdev/hipanel-module-ticket/commit/5e8f83f
[4b79a12]: https://github.com/hiqdev/hipanel-module-ticket/commit/4b79a12
[22d6fc2]: https://github.com/hiqdev/hipanel-module-ticket/commit/22d6fc2
[ac577a5]: https://github.com/hiqdev/hipanel-module-ticket/commit/ac577a5
[c3051a3]: https://github.com/hiqdev/hipanel-module-ticket/commit/c3051a3
[d9d7e3e]: https://github.com/hiqdev/hipanel-module-ticket/commit/d9d7e3e
[d58ec64]: https://github.com/hiqdev/hipanel-module-ticket/commit/d58ec64
[dad65ee]: https://github.com/hiqdev/hipanel-module-ticket/commit/dad65ee
[d755715]: https://github.com/hiqdev/hipanel-module-ticket/commit/d755715
[772d75b]: https://github.com/hiqdev/hipanel-module-ticket/commit/772d75b
[74214d1]: https://github.com/hiqdev/hipanel-module-ticket/commit/74214d1
[724c2f5]: https://github.com/hiqdev/hipanel-module-ticket/commit/724c2f5
[dc0ceb5]: https://github.com/hiqdev/hipanel-module-ticket/commit/dc0ceb5
[28b0543]: https://github.com/hiqdev/hipanel-module-ticket/commit/28b0543
[cc0974c]: https://github.com/hiqdev/hipanel-module-ticket/commit/cc0974c
[9bb4a63]: https://github.com/hiqdev/hipanel-module-ticket/commit/9bb4a63
[efae406]: https://github.com/hiqdev/hipanel-module-ticket/commit/efae406
[f83f183]: https://github.com/hiqdev/hipanel-module-ticket/commit/f83f183
[89e5dee]: https://github.com/hiqdev/hipanel-module-ticket/commit/89e5dee
[c7a1ac5]: https://github.com/hiqdev/hipanel-module-ticket/commit/c7a1ac5
[5bac650]: https://github.com/hiqdev/hipanel-module-ticket/commit/5bac650
[932ae2b]: https://github.com/hiqdev/hipanel-module-ticket/commit/932ae2b
[eb9cbba]: https://github.com/hiqdev/hipanel-module-ticket/commit/eb9cbba
[Under development]: https://github.com/hiqdev/hipanel-module-ticket/releases
[cfb3b38]: https://github.com/hiqdev/hipanel-module-ticket/commit/cfb3b38
[15e696a]: https://github.com/hiqdev/hipanel-module-ticket/commit/15e696a
[b272278]: https://github.com/hiqdev/hipanel-module-ticket/commit/b272278
[b3e3e24]: https://github.com/hiqdev/hipanel-module-ticket/commit/b3e3e24
[16ebc98]: https://github.com/hiqdev/hipanel-module-ticket/commit/16ebc98
[5c951db]: https://github.com/hiqdev/hipanel-module-ticket/commit/5c951db
[1c04a51]: https://github.com/hiqdev/hipanel-module-ticket/commit/1c04a51
[cc71087]: https://github.com/hiqdev/hipanel-module-ticket/commit/cc71087
[ba9b56f]: https://github.com/hiqdev/hipanel-module-ticket/commit/ba9b56f
[a87b394]: https://github.com/hiqdev/hipanel-module-ticket/commit/a87b394
[a732b92]: https://github.com/hiqdev/hipanel-module-ticket/commit/a732b92
[3e04111]: https://github.com/hiqdev/hipanel-module-ticket/commit/3e04111
[d7bec02]: https://github.com/hiqdev/hipanel-module-ticket/commit/d7bec02
[b7b5615]: https://github.com/hiqdev/hipanel-module-ticket/commit/b7b5615
[740bfbe]: https://github.com/hiqdev/hipanel-module-ticket/commit/740bfbe
[1a86bae]: https://github.com/hiqdev/hipanel-module-ticket/commit/1a86bae

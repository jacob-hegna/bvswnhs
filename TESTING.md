Testing Guidelines
=================

What follows are guidelines to testing and QA procedure as it applies to the development of the BVSW NHS site.

#Issues

##Issue Creation
When issues are made, either by development or QA, they are to be made with steps to recreate the bug. Open bugs are to be labeled `unresolved` to show that they are, well, unresolved.

##Issue Resolving

###Dev
When development fixes a bug, associate a commit with the issue by saying "closes #32" or "resolves #7" or "fixes #1047" or what have you. Github should auto close the issue, but the issue after being closed has to be labeled `build` by development.

###QA
Once an issue is marked `build`, QA can then run tests on the new build to verify that the bug is in fact repaired. If the fix is satisfactory to QA, then the closed issue should be marked `resolved`. Otherwise, the issue should be reopened and relabeled `unresolved`.

----

The procedures documented in this  document are self-documenting in that the last paragraph of this document documents that the document can still be revised to fit the needs and desires of the [insert final site name here] team.

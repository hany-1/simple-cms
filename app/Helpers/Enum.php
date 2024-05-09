<?php
//Register at AppServiceProvider


//POST TYPE
const POST = 'POST';
const PAGE = 'PAGE';

// STATUS
const DRAFT = 'DRAFT'; // Incomplete post viewable by anyone with proper user role.
const PUBLISHED = 'PUBLISHED'; // Viewable by everyone
const PENDING = 'PENDING'; // Awaiting a user with publish post permission to publish (user role typically Editor)
const SCHEDULED = 'SCHEDULED'; // Scheduled to be published in a future date
const TRASH = 'TRASH'; // Posts in trash are assigned the trash status (deleted)

// USER STATUS
const ACTIVE = 'ACTIVE';
const INACTIVE = 'INACTIVE';

// COMMENT STATUS
const HOLD = 'HOLD';
const APPROVE = 'APPROVE';
const SPAM = 'SPAM';

// TERM TAXANOMY
const POST_TAG = 'POST_TAG'; // default is POST_TAG
const PAGE_TAG = 'PAGE_TAG';
const CATEGORY = 'CATEGORY';
const THEME = 'THEME';

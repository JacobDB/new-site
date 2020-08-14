// JavaScript Document

// Scripts written by __gulp_init_author_name__ @ __gulp_init_author_company__

import { library, dom } from "@fortawesome/fontawesome-svg-core";

import { faBars           as fasFaBars           } from "@fortawesome/pro-solid-svg-icons/faBars";
import { faCaretDown      as fasFaCaretDown      } from "@fortawesome/pro-solid-svg-icons/faCaretDown";
import { faCaretLeft      as fasFaCaretLeft      } from "@fortawesome/pro-solid-svg-icons/faCaretLeft";
import { faCaretRight     as fasFaCaretRight     } from "@fortawesome/pro-solid-svg-icons/faCaretRight";
import { faClock          as fasFaClock          } from "@fortawesome/pro-solid-svg-icons/faClock";
import { faComment        as fasFaComment        } from "@fortawesome/pro-solid-svg-icons/faComment";
import { faFolder         as fasFaFolder         } from "@fortawesome/pro-solid-svg-icons/faFolder";
import { faQuestionCircle as fasFaQuestionCircle } from "@fortawesome/pro-solid-svg-icons/faQuestionCircle";
import { faSearch         as fasFaSearch         } from "@fortawesome/pro-solid-svg-icons/faSearch";
import { faTag            as fasFaTag            } from "@fortawesome/pro-solid-svg-icons/faTag";
import { faUserCircle     as fasFaUserCircle     } from "@fortawesome/pro-solid-svg-icons/faUserCircle";

/**
 * Add solid icons
 */
library.add(fasFaBars, fasFaCaretDown, fasFaCaretLeft, fasFaCaretRight, fasFaClock, fasFaComment, fasFaFolder, fasFaQuestionCircle, fasFaSearch, fasFaTag, fasFaUserCircle);

/**
 * Watch the DOM to insert icons
 */
dom.watch();

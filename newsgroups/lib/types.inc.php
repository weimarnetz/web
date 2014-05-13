<?php
/*
 *  NewsPortal: Data type declarations
 *
 *  Copyright (C) 2002-2004 Florian Amrhein
 *  E-Mail: newsportal@florian-amrhein.de
 *  Web: http://florian-amrhein.de
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */


/*
 * the name and the description of a newsgroup
 */
class newsgroupType {
  var $name;
  var $description;
  var $count;
  var $text;
}

/*
 * Stores a complete article:
 * - The parsed Header as an headerType
 * - The bodies and attachments as an array of array of lines
 */
class messageType {
  var $header;
  var $body;
}



/*
 * Stores the Header of an article
 */
class headerType {
  var $number; // the Number of an article inside a group
  var $id;     // Message-ID
  var $from;   // eMail of the author
  var $name;   // Name of the author
  var $subject; // the subject
  var $newsgroups;  // the Newsgroups where the article belongs to
  var $followup;
  var $date;         // timestamp of the article
  var $date_thread;  // timestamp of the newest article in the thread
  var $organization;
  var $xnoarchive;
  var $references;     // all references to the article
  var $bestreference;  // nearest reference found
  var $content_transfer_encoding;
  var $mime_version;
  var $content_type;   // array, Content-Type of the Body (Index=0) and the
                       // Attachments (Index>0)
  var $content_type_charset;  // like content_type
  var $content_type_name;     // array of the names of the attachments
  var $content_type_boundary; // The boundary of an multipart-article.
  var $content_type_format;   // array, is the body in flowed format?
  var $answers;    // which articles are followups of this article?
  var $isAnswer;   // is the article an answer to an other article?
  var $username;
  var $user_agent;
  var $isReply;    // has this article "Re: " at the beginning of the subject?
  var $threadsize; // number of articles in this thread
}
?>

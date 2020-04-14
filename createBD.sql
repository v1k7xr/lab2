/*==============================================================*/
/* DBMS name:      PostgreSQL 9.x                               */
/* Created on:     01.04.2020 13:08:29                          */
/*==============================================================*/


drop index Contains_FK;

drop index File_PK;

drop table File;

drop index Create_FK;

drop index Post_PK;

drop table Post;

drop index User_PK;

drop table "User";

/*==============================================================*/
/* Table: File                                                  */
/*==============================================================*/
create table File (
   fileID               SERIAL not null,
   postID               INT4                 not null,
   fileNameUser         VARCHAR(75)          not null,
   fileNameHashSum      VARCHAR(32)          not null,
   constraint PK_FILE primary key (fileID)
);

/*==============================================================*/
/* Index: File_PK                                               */
/*==============================================================*/
create unique index File_PK on File (
fileID
);

/*==============================================================*/
/* Index: Contains_FK                                           */
/*==============================================================*/
create  index Contains_FK on File (
postID
);

/*==============================================================*/
/* Table: Post                                                  */
/*==============================================================*/
create table Post (
   postID               SERIAL not null,
   userID               INT4                 not null,
   postAddDate          DATE                 not null,
   postDescription      TEXT                 null,
   constraint PK_POST primary key (postID)
);

/*==============================================================*/
/* Index: Post_PK                                               */
/*==============================================================*/
create unique index Post_PK on Post (
postID
);

/*==============================================================*/
/* Index: Create_FK                                             */
/*==============================================================*/
create  index Create_FK on Post (
userID
);

/*==============================================================*/
/* Table: "User"                                                */
/*==============================================================*/
create table "User" (
   userID               SERIAL not null,
   userName             VARCHAR(125)         not null,
   userEmail            VARCHAR(50)          not null,
   userPsswrd           VARCHAR(32)          not null,
   userPsswrdSlt        VARCHAR(7)           not null,
   constraint PK_USER primary key (userID)
);

/*==============================================================*/
/* Index: User_PK                                               */
/*==============================================================*/
create unique index User_PK on "User" (
userID
);

alter table File
   add constraint FK_FILE_CONTAINS_POST foreign key (postID)
      references Post (postID)
      on delete restrict on update restrict;

alter table Post
   add constraint FK_POST_CREATE_USER foreign key (userID)
      references "User" (userID)
      on delete restrict on update restrict;


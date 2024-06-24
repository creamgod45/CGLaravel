create table if not exists animals
(
    id          bigint unsigned auto_increment
        primary key,
    type_id     int unsigned         not null comment '動物分類',
    name        varchar(255)         not null comment '動物的暱稱',
    birthday    date                 null comment '生日',
    area        varchar(255)         null comment '所在地區',
    fix         tinyint(1) default 0 not null comment '結紮情形',
    description text                 null comment '簡單敘述',
    personality text                 null comment '動物個性',
    created_at  timestamp            null,
    updated_at  timestamp            null
)
    collate = utf8mb4_unicode_ci;

alter table animals
    add constraint animals_type_id_unique
        unique (type_id);

create table if not exists jobs
(
    id           bigint unsigned auto_increment
        primary key,
    queue        varchar(255)     not null,
    payload      longtext         not null,
    attempts     tinyint unsigned not null,
    reserved_at  int unsigned     null,
    available_at int unsigned     not null,
    created_at   int unsigned     not null
)
    collate = utf8mb4_unicode_ci;

create index jobs_queue_index
    on jobs (queue);

create table if not exists members
(
    id                bigint unsigned auto_increment
        primary key,
    UUID              char(36)                               not null,
    username          varchar(255)                           not null,
    email             varchar(255)                           not null,
    email_verified_at timestamp                              null,
    password          text                                   not null,
    phone             varchar(255)                           not null,
    enable            enum ('false', 'true') default 'false' not null,
    administrator     enum ('false', 'true') default 'false' not null,
    remember_token    varchar(100)                           null,
    created_at        timestamp                              null,
    updated_at        timestamp                              null
)
    collate = utf8mb4_unicode_ci;

alter table members
    add constraint members_email_unique
        unique (email);

alter table members
    add constraint members_phone_unique
        unique (phone);

alter table members
    add constraint members_username_unique
        unique (username);

create table if not exists migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table if not exists password_reset_tokens
(
    id         bigint unsigned auto_increment
        primary key,
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index password_reset_tokens_email_index
    on password_reset_tokens (email);

create table if not exists personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

alter table personal_access_tokens
    add constraint personal_access_tokens_token_unique
        unique (token);

create table if not exists sessions
(
    id            varchar(255)    not null,
    user_id       bigint unsigned null,
    ip_address    varchar(45)     null,
    user_agent    text            null,
    payload       longtext        not null,
    last_activity int             not null
)
    collate = utf8mb4_unicode_ci;

create index sessions_last_activity_index
    on sessions (last_activity);

create index sessions_user_id_index
    on sessions (user_id);

alter table sessions
    add primary key (id);



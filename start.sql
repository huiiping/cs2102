INSERT INTO users (name, email, password, address, display_pic, logonType) VALUES ('Oliver', 'oliver@gmail.com', '123', 'Orchard Boulevard', '', 'USERPUBLIC');
INSERT INTO users (name, email, password, address, display_pic, logonType) VALUES ('Jamie', 'jamie@gmail.com', '123', 'Bugis Town', '', 'USERPUBLIC');
INSERT INTO users (name, email, password, address, display_pic, logonType) VALUES ('Danny', 'danny@dan.com', '123', 'Chinatown', '', 'USERPUBLIC');
INSERT INTO users (name, email, password, address, display_pic, logonType) VALUES ('Zen', 'zen@gmail.com', '123', 'West Coast', '', 'USERPUBLIC');
INSERT INTO users (name, email, password, address, display_pic, logonType) VALUES ('Joo', 'joo@gmail.com', '123', 'East Coast', '', 'USERPUBLIC');

INSERT INTO category (catid, name) VALUES ('80', 'Appliances');
INSERT INTO category (catid, name) VALUES ('81', 'Home Maintenance');
INSERT INTO category (catid, name) VALUES ('82', 'Personal Care');
INSERT INTO category (catid, name) VALUES ('83', 'Books');
INSERT INTO category (catid, name) VALUES ('84', 'Arts and Crafts');

INSERT INTO item (itemid, item_name, description, availability, loanSetting, owner, category, item_pic) VALUES ('001', 'Hair Dryer', 'Hair Dryer', 'YES', 'SHARE', 'oliver@gmail.com', '80', 'HairDryer.jpg');
INSERT INTO item (itemid, item_name, description, availability, loanSetting, owner, category, item_pic) VALUES ('002', 'Shaver', 'Shaver', 'YES', 'SHARE', 'oliver@gmail.com', '80', 'Shaver.jpg');
INSERT INTO item (itemid, item_name, description, availability, loanSetting, owner, category, item_pic) VALUES ('003', 'Bread Toaster', 'Bread Toaster', 'NO', 'SHARE', 'oliver@gmail.com', '80', 'BreadToaster.jpg');
INSERT INTO item (itemid, item_name, description, availability, loanSetting, owner, category, item_pic) VALUES ('004', 'Toothpaste', 'Toothpaste', 'NO', 'BID', 'danny@dan.com', '82', 'Toothpaste.jpg');
INSERT INTO item (itemid, item_name, description, availability, loanSetting, owner, category, item_pic) VALUES ('005', 'Scissor', 'Scissor', 'NO', 'BID', 'joo@gmail.com', '84', 'Scissor.jpg');

INSERT INTO bid (bidid, bidamt, itemid, bidder, datelastbid) VALUES ('001', '$1', '004', 'oliver@gmail.com', NOW());
INSERT INTO bid (bidid, bidamt, itemid, bidder, datelastbid) VALUES ('002', '$1', '005', 'oliver@gmail.com', NOW());

INSERT INTO loan (itemid, bidid, borrower, borrowedbegin, borrowedend) VALUES ('004', '001', 'oliver@gmail.com', NOW(), NOW());
INSERT INTO loan (itemid, bidid, borrower, borrowedbegin, borrowedend) VALUES ('005', '002', 'oliver@gmail.com', NOW(), NOW());
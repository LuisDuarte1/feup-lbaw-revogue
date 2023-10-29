SET search_path TO lbaw23107;

DROP TABLE IF EXISTS
    Users,
    Products,
    Orders,
    Attributes,
    ProductAttributes,
    FederatedAuthentications,
    Messages,
    Vouchers,
    Reviews,
    Reports,
    Notifications,
    ProductWishlist,
    CartProduct,
    Admins,
    OrderProduct,
    Payouts CASCADE;

DROP TYPE IF EXISTS
    AccountStatus, OrderStatus, MessageType, BargainStatus, ReportType, NotificationType;


CREATE TYPE AccountStatus AS ENUM('needsConfirmation', 'active', 'banned');
CREATE TYPE OrderStatus AS ENUM(
    'pendingPayment', 'requestCancellation', 'cancelled', 'pendingShipment', 'shipped', 'received'
);
CREATE TYPE MessageType AS ENUM(
  'bargain',
  'text'
);
CREATE TYPE BargainStatus AS ENUM(
  'pending',
  'rejected',
  'accepted'
);

CREATE TYPE ReportType AS ENUM (
    'user',
    'product',
    'message'
);

CREATE TYPE NotificationType AS ENUM (
    'wishlist',
    'cart',
    'orderStatus',
    'review',
    'message'
);

CREATE TABLE Users(
    id INT PRIMARY KEY NOT NULL,
    username TEXT UNIQUE NOT NULL,
    displayName TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    profileImagePath TEXT,
    bio TEXT,
    password TEXT,
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    settings JSON NOT NULL,
    accountStatus AccountStatus NOT NULL DEFAULT 'needsConfirmation'::AccountStatus
);

CREATE TABLE FederatedAuthentications(
  provider TEXT NOT NULL,
  refreshToken TEXT NOT NULL,
  accessToken TEXT NOT NULL,
  userId int NOT NULL,
  PRIMARY KEY (provider, userId),
  FOREIGN KEY (userId) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Products(
    id INT PRIMARY KEY NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    description TEXT,
    price NUMERIC NOT NULL CHECK ( price >= 0 ),
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    imagePaths TEXT[] check ( array_length(imagePaths, 1) >= 1 ),
    soldBy INT,
    FOREIGN KEY (soldBy) REFERENCES Users(id) ON DELETE SET NULL
);

CREATE TABLE Attributes(
    id INT PRIMARY KEY NOT NULL,
    key TEXT NOT NULL,
    value TEXT NOT NULL,
    UNIQUE (key, value)
);

CREATE TABLE ProductAttributes(
  product INT NOT NULL,
  attribute INT NOT NULL,
  PRIMARY KEY (product, attribute),
  FOREIGN KEY (product) REFERENCES Products(id) ON DELETE CASCADE,
  FOREIGN KEY (attribute) REFERENCES Attributes(id) ON DELETE CASCADE
);

CREATE TABLE Orders(
    id INT PRIMARY KEY,
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    status OrderStatus
);

CREATE TABLE Messages(
    id INT PRIMARY KEY,
    sentDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( sentDate <= CURRENT_TIMESTAMP ),
    messageType MessageType NOT NULL,
    textContent TEXT,
    imagePath TEXT,
    proposedPrice NUMERIC,
    bargainStatus BargainStatus,
    fromUser INT,
    toUser INT,
    subjectProduct INT,
    FOREIGN KEY (fromUser) REFERENCES Users(id) ON DELETE SET NULL,
    FOREIGN KEY (toUser) REFERENCES Users(id) ON DELETE SET NULL,
    FOREIGN KEY (subjectProduct) REFERENCES Products(id) ON DELETE SET NULL,
    CHECK ((messageType = 'text' AND
            (textContent IS NOT NULL OR imagePath IS NOT NULL)) OR
           (messageType = 'bargain' AND
            (bargainStatus IS NOT NULL AND proposedPrice IS NOT NULL AND proposedPrice >= 0))
        )
);

CREATE TABLE Vouchers(
    code TEXT PRIMARY KEY,
    belongsTo INT NOT NULL,
    product INT NOT NULL,
    bargainMessage INT NOT NULL,
    FOREIGN KEY (belongsTo) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (product) REFERENCES Products(id) ON DELETE CASCADE,
    FOREIGN KEY (bargainMessage) REFERENCES Messages(id) ON DELETE CASCADE
);

CREATE TABLE Reviews(
    id INT PRIMARY KEY,
    stars NUMERIC NOT NULL CHECK ( stars >= 0 AND stars <= 5 ),
    description TEXT,
    imagePaths TEXT[] NOT NULL CHECK (array_length(imagePaths, 1) >= 1),
    reviewedOrder INT NOT NULL,
    reviewer INT NOT NULL,
    reviewed INT NOT NULL,
    FOREIGN KEY (reviewedOrder) REFERENCES Orders(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Admins(
    id INT PRIMARY KEY NOT NULL,
    email TEXT UNIQUE NOT NULL,
    profileImagePath TEXT,
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    password TEXT
);

CREATE TABLE Reports(
    id INT PRIMARY KEY NOT NULL,
    type ReportType NOT NULL,
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    isClosed BOOLEAN NOT NULL DEFAULT FALSE,
    closedBy INT,
    reporter INT,
    reported INT,
    product INT,
    message INT,
    FOREIGN KEY (closedBy) REFERENCES Admins(id) ON DELETE SET NULL,
    FOREIGN KEY (reporter) REFERENCES Users(id) ON DELETE SET NULL,
    FOREIGN KEY (reported) REFERENCES Users(id) ON DELETE SET NULL,
    FOREIGN KEY (product) REFERENCES Products(id) ON DELETE SET NULL,
    FOREIGN KEY (message) REFERENCES Messages(id) ON DELETE SET NULL,
    CHECK ( (type = 'message' AND message IS NOT NULL) OR
            (type = 'user' AND reported IS NOT NULL) OR
            (type = 'product' AND product IS NOT NULL) )
);

CREATE TABLE Notifications(
    id INT PRIMARY KEY,
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    read BOOLEAN NOT NULL DEFAULT FALSE,
    dismissed BOOLEAN NOT NULL DEFAULT FALSE,
    type NotificationType NOT NULL,
    belongsTo INT NOT NULL,
    orderId INT,
    wishlistProduct INT,
    cartProduct INT,
    review INT,
    message INTEGER,
    FOREIGN KEY (belongsTo) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (orderId) REFERENCES Orders(id) ON DELETE CASCADE,
    FOREIGN KEY (wishlistProduct) REFERENCES Products(id),
    FOREIGN KEY (cartProduct) REFERENCES Products(id),
    FOREIGN KEY (review) REFERENCES Reviews(id),
    FOREIGN KEY (message) REFERENCES  Messages(id),
    CHECK ( (type = 'orderStatus' AND orderId IS NOT NULL) OR
            (type = 'wishlist' AND wishlistProduct IS NOT NULL) OR
            (type = 'cart' AND cartProduct IS NOT NULL) OR
            (type = 'review' AND review IS NOT NULL) OR
            (type = 'message' AND message IS NOT NULL)
    )
);

CREATE TABLE ProductWishlist(
    product INT NOT NULL,
    belongsTo INT NOT NULL,
    PRIMARY KEY (product, belongsTo),
    FOREIGN KEY (product) REFERENCES Products(id) ON DELETE CASCADE,
    FOREIGN KEY (belongsTo) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE CartProduct(
    product INT NOT NULL,
    belongsTo INT NOT NULL,
    appliedVoucher TEXT,
    PRIMARY KEY (product, belongsTo),
    FOREIGN KEY (product) REFERENCES Products(id) ON DELETE CASCADE,
    FOREIGN KEY (belongsTo) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (appliedVoucher) REFERENCES Vouchers(code) ON DELETE SET NULL
);

CREATE TABLE OrderProduct(
    product INT NOT NULL,
    orderId INT NOT NULL,
    discount NUMERIC NOT NULL DEFAULT 0 check ( discount >= 0 ),
    PRIMARY KEY (product, orderId),
    FOREIGN KEY (product) REFERENCES Products(id),
    FOREIGN KEY (orderId) REFERENCES Orders(id)
);

CREATE TABLE Payouts(
    id TEXT PRIMARY KEY NOT NULL,
    creationDate DATE NOT NULL DEFAULT CURRENT_DATE CHECK ( creationDate <= CURRENT_DATE ),
    tax NUMERIC NOT NULL CHECK ( tax <= 1 AND tax >= 0 ),
    paidTo INT,
    FOREIGN KEY (paidTo) REFERENCES Users(id) ON DELETE SET NULL
);

-- INDICES


CREATE INDEX notification_search_index ON Notifications USING hash(belongsTo);

CREATE INDEX product_wishlist_user_search_index ON ProductWishlist USING hash(belongsTo);

CREATE INDEX message_thread_search_index ON Messages USING btree(fromUser, toUser, subjectProduct);

-- FTS

ALTER TABLE Products ADD COLUMN fts_search TSVECTOR;

CREATE OR REPLACE FUNCTION product_fts_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.fts_search = (
            setweight(to_tsvector('english', NEW.name), 'A') ||
            setweight(to_tsvector('english',
                        coalesce(string_agg((SELECT string_agg(a.value, ' ') FROM ProductAttributes pa JOIN Attributes a
                        ON a.id=pa.attribute WHERE pa.product=NEW.id GROUP BY pa.product), ''), ' ')), 'B') ||
            setweight(to_tsvector('english', coalesce(NEW.description, '')), 'C')
            );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
            NEW.fts_search = (
                setweight(to_tsvector('english', NEW.name), 'A') ||
                setweight(to_tsvector('english',
                        coalesce(string_agg((SELECT string_agg(a.value, ' ') FROM ProductAttributes pa JOIN Attributes a
                        ON a.id=pa.attribute WHERE pa.product=NEW.id GROUP BY pa.product), ''), ' ')), 'B') ||
                setweight(to_tsvector('english', COALESCE(NEW.description, '')), 'C')
                );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS product_search ON Products;
CREATE TRIGGER product_search BEFORE INSERT OR UPDATE ON Products
    FOR EACH ROW EXECUTE PROCEDURE product_fts_update();


CREATE OR REPLACE FUNCTION product_attributes_update() RETURNS TRIGGER AS $$
BEGIN
    UPDATE Products SET fts_search=(
        setweight(to_tsvector('english', (SELECT name FROM Products where id=NEW.product)), 'A') ||
        setweight(to_tsvector('english',
                    coalesce((SELECT string_agg(a.value, ' ') FROM ProductAttributes pa JOIN Attributes a
                        ON a.id=pa.attribute WHERE pa.product=NEW.product GROUP BY pa.product), '')), 'B') ||
        setweight(to_tsvector('english', coalesce((SELECT description FROM Products where id=NEW.product), '')), 'C'))
        WHERE id=NEW.product;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS product_attributes_search ON ProductAttributes;
CREATE TRIGGER product_attributes_search AFTER INSERT OR DELETE ON ProductAttributes
    FOR EACH ROW EXECUTE PROCEDURE product_attributes_update();

CREATE INDEX product_search ON Products USING GIN(fts_search);

-- trigger01

CREATE OR REPLACE FUNCTION has_accepted_bargain() RETURNS TRIGGER AS $$
BEGIN
   IF (SELECT bargainStatus FROM Messages WHERE id=NEW.bargainMessage) <> 'accepted' THEN
        RAISE EXCEPTION 'Invalid bargain message status...';
   end if;
   RETURN NEW;
END
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS voucher_has_accepted_bargain ON Vouchers;
CREATE TRIGGER voucher_has_accepted_bargain BEFORE INSERT OR UPDATE ON Vouchers
    FOR EACH ROW EXECUTE PROCEDURE has_accepted_bargain();

-- trigger02

CREATE OR REPLACE FUNCTION voucher_belongs_to_user() RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT belongsTo FROM Vouchers WHERE code=NEW.appliedVoucher) <> NEW.belongsTo THEN
        RAISE EXCEPTION 'Voucher doesnt belong to current user...';
    end if;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS cart_voucher_validity ON CartProduct;
CREATE TRIGGER cart_voucher_validity BEFORE INSERT OR UPDATE ON CartProduct
    FOR EACH ROW EXECUTE PROCEDURE voucher_belongs_to_user();

-- trigger03

CREATE OR REPLACE FUNCTION order_product_unique_if_not_cancelled() RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT COUNT(*) FROM OrderProduct op JOIN Orders O on O.id = op.orderId WHERE O.status <> 'cancelled'
                                                                                  AND op.product=NEW.product) <> 0 THEN
        RAISE EXCEPTION 'Product has already a active order';
    end if;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS order_product_validity ON OrderProduct;
CREATE TRIGGER order_product_validity BEFORE INSERT OR UPDATE ON OrderProduct
    FOR EACH ROW EXECUTE PROCEDURE order_product_unique_if_not_cancelled();

-- trigger04

CREATE OR REPLACE FUNCTION notification_wishlist_cart_valid() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.type = 'wishlist' AND (SELECT COUNT(*) FROM ProductWishlist WHERE product=NEW.wishlistProduct AND belongsTo=NEW.belongsTo) <> 1 THEN
        RAISE EXCEPTION 'User doesnt have product in his wishlist...';
    END IF;
    IF NEW.type = 'cart' AND (SELECT COUNT(*) FROM CartProduct WHERE product=NEW.wishlistProduct AND belongsTo=NEW.belongsTo) <> 1 THEN
        RAISE EXCEPTION 'User doesnt have product in his cart...';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS notification_wishlist_cart_validity ON Notifications;
CREATE TRIGGER notification_wishlist_cart_validity BEFORE INSERT OR UPDATE ON Notifications
    FOR EACH ROW EXECUTE PROCEDURE notification_wishlist_cart_valid();

-- trigger05

CREATE OR REPLACE FUNCTION review_check_if_order_is_received() RETURNS TRIGGER AS $$
BEGIN

    IF (SELECT status FROM Orders WHERE id=NEW.reviewedOrder) <> 'received' THEN
        RAISE EXCEPTION 'Order has not been received therefore it couldnt create a review';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS review_check_order_validity ON Reviews;
CREATE TRIGGER review_check_order_validity BEFORE INSERT OR UPDATE ON Reviews
    FOR EACH ROW EXECUTE PROCEDURE review_check_if_order_is_received();

-- trigger06

CREATE OR REPLACE FUNCTION bargain_message_order_validity() RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT COUNT(*) FROM OrderProduct WHERE product=NEW.subjectProduct) = 0 THEN
        RETURN NEW;
    END IF;
    IF (SELECT COUNT(*) FROM OrderProduct op JOIN Orders O on O.id = op.orderId WHERE op.product=NEW.subjectProduct AND O.status <> 'cancelled') = 0 THEN
        RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Product has pending or delivered order, so we cant create/edit a bargain';
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS bargain_message_order_status_validity ON Messages;
CREATE TRIGGER bargain_message_order_status_validity BEFORE INSERT OR UPDATE ON Messages
    FOR EACH ROW EXECUTE PROCEDURE bargain_message_order_validity();

-- trigger07

CREATE OR REPLACE FUNCTION bargain_message_price_validity() RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT price FROM Products WHERE id=NEW.subjectProduct) <= NEW.proposedPrice THEN
        RAISE EXCEPTION 'You cant bargain a higher price than the current price of the product';
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS bargain_message_price_valid ON Messages;
CREATE TRIGGER bargain_message_priceV_valid BEFORE INSERT OR UPDATE ON Messages
    FOR EACH ROW EXECUTE PROCEDURE bargain_message_price_validity();

-- trigger08

CREATE OR REPLACE FUNCTION product_attribute_unique_key() RETURNS TRIGGER AS $$
BEGIN
    IF ((SELECT count(*) FROM ProductAttributes pa JOIN Attributes a ON a.id=pa.attribute
                         WHERE a.key=(SELECT key FROM Attributes WHERE id=NEW.attribute) AND pa.product=NEW.product) <> 0) THEN
        RAISE EXCEPTION 'You can only have one value per key in a product attribute';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS product_attribute_unique_validity ON ProductAttributes;
CREATE TRIGGER product_attribute_unique_validity BEFORE INSERT OR UPDATE ON ProductAttributes
    FOR EACH ROW EXECUTE PROCEDURE product_attribute_unique_key();
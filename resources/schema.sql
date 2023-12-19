SET search_path TO lbaw23107;

DROP TABLE IF EXISTS
    Users,
    Products,
    PurchaseIntents,
    PurchaseIntentProduct,
    Orders,
    Attributes,
    ProductAttributes,
    FederatedAuthentications,
    Messages,
    Vouchers,
    Reviews,
    Purchases,
    Reports,
    Notifications,
    ProductWishlist,
    CartProduct,
    Admins,
    OrderProduct,
    Categories,
    Jobs,
    "failed_jobs",
    Payouts CASCADE;

DROP TYPE IF EXISTS
    AccountStatus, OrderStatus, MessageType, BargainStatus, ReportType, NotificationType, PaymentMethod;


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

CREATE TYPE PaymentMethod AS ENUM(
    'delivery',
    'stripe'
);

CREATE TYPE NotificationType AS ENUM (
    'wishlist',
    'cart',
    'order_status',
    'review',
    'message',
    'sold'
);

CREATE TABLE Users(
    "id" SERIAL PRIMARY KEY NOT NULL,
    "username" TEXT UNIQUE NOT NULL,
    "date_birth" DATE NOT NULL,
    "display_name" TEXT NOT NULL,
    "email" TEXT UNIQUE NOT NULL,
    "profile_image_path" TEXT,
    "bio" TEXT,
    "password" TEXT,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP ),
    "settings" JSON NOT NULL,
    "account_status" AccountStatus NOT NULL DEFAULT 'needsConfirmation'::AccountStatus
);

CREATE TABLE FederatedAuthentications(
  "id" SERIAL PRIMARY KEY NOT NULL,
  "provider" TEXT NOT NULL,
  "refresh_token" TEXT NOT NULL,
  "access_token" TEXT NOT NULL,
  "user_id" int NOT NULL,
  UNIQUE ("provider", "user_id"),
  FOREIGN KEY ("user_id") REFERENCES Users(id) ON DELETE CASCADE
);
CREATE TABLE Categories(
    "id" SERIAL PRIMARY KEY NOT NULL,
    "name" TEXT UNIQUE NOT NULL,
    "parent_category" INT,
    FOREIGN KEY ("parent_category") REFERENCES Categories("id") ON DELETE CASCADE
);

CREATE TABLE Products(
    "id" SERIAL PRIMARY KEY NOT NULL,
    "slug" TEXT UNIQUE NOT NULL,
    "name" TEXT NOT NULL,
    "description" TEXT,
    "price" NUMERIC NOT NULL CHECK ( "price" >= 0 ),
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP ),
    "image_paths" JSON NOT NULL CHECK ( json_array_length("image_paths") > 0 ),
    "sold_by" INT,
    "category" INT,
    FOREIGN KEY ("sold_by") REFERENCES Users("id") ON DELETE SET NULL,
    FOREIGN KEY ("category") REFERENCES Categories("id") ON DELETE SET NULL
);

CREATE TABLE Attributes(
    "id" SERIAL PRIMARY KEY NOT NULL,
    "key" TEXT NOT NULL,
    "value" TEXT NOT NULL,
    UNIQUE ("key", "value")
);

CREATE TABLE ProductAttributes(
  "product" INT NOT NULL,
  "attribute" INT NOT NULL,
  PRIMARY KEY ("product", "attribute"),
  FOREIGN KEY ("product") REFERENCES Products("id") ON DELETE CASCADE,
  FOREIGN KEY ("attribute") REFERENCES Attributes("id") ON DELETE CASCADE
);

CREATE TABLE PurchaseIntents(
    "id" SERIAL PRIMARY KEY,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP ),
    "shipping_address" JSON NOT NULL,
    "payment_intent_id" TEXT UNIQUE NOT NULL,
    "user" INT NOT NULL,
    FOREIGN KEY ("user") REFERENCES Users("id") ON DELETE CASCADE
);

CREATE TABLE PurchaseIntentProduct(
    "purchase_intent" INT NOT NULL,
    "product" INT UNIQUE NOT NULL,
    FOREIGN KEY ("purchase_intent") REFERENCES PurchaseIntents("id") ON DELETE CASCADE,
    FOREIGN KEY ("product") REFERENCES Products("id") ON DELETE CASCADE
);

CREATE TABLE Purchases(
    "id" SERIAL PRIMARY KEY,
    "method" PaymentMethod NOT NULL,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP )
);

CREATE TABLE Orders(
    "id" SERIAL PRIMARY KEY,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP ),
    "status" OrderStatus,
    "shipping_address" JSON NOT NULL,
    "belongs_to" INT,
    "purchase" INT NOT NULL,
    FOREIGN KEY ("belongs_to") REFERENCES Users("id") ON DELETE SET NULL,
    FOREIGN KEY ("purchase") REFERENCES Purchases("id")
);

CREATE TABLE Messages(
    "id" SERIAL PRIMARY KEY,
    "sent_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "sent_date" <= CURRENT_TIMESTAMP ),
    "message_type" MessageType NOT NULL,
    "text_content" TEXT,
    "image_path" TEXT,
    "proposed_price" NUMERIC,
    "bargain_status" BargainStatus,
    "from_user" INT,
    "to_user" INT,
    "subject_product" INT,
    FOREIGN KEY ("from_user") REFERENCES Users("id") ON DELETE SET NULL,
    FOREIGN KEY ("to_user") REFERENCES Users("id") ON DELETE SET NULL,
    FOREIGN KEY ("subject_product") REFERENCES Products("id") ON DELETE SET NULL,
    CHECK (("message_type" = 'text' AND
            ("text_content" IS NOT NULL OR "image_path" IS NOT NULL)) OR
           ("message_type" = 'bargain' AND
            ("bargain_status" IS NOT NULL AND "proposed_price" IS NOT NULL AND "proposed_price" >= 0))
        )
);

CREATE TABLE Vouchers(
    "code" TEXT PRIMARY KEY,
    "belongs_to" INT NOT NULL,
    "product" INT NOT NULL,
    "bargain_message" INT NOT NULL,
    FOREIGN KEY ("belongs_to") REFERENCES Users("id") ON DELETE CASCADE,
    FOREIGN KEY ("product") REFERENCES Products("id") ON DELETE CASCADE,
    FOREIGN KEY ("bargain_message") REFERENCES Messages("id") ON DELETE CASCADE
);

CREATE TABLE Reviews(
    "id" SERIAL PRIMARY KEY,
    "stars" NUMERIC NOT NULL CHECK ( "stars" >= 0 AND "stars" <= 5 ),
    "description" TEXT,
    "image_paths" TEXT[] NOT NULL CHECK (array_length("image_paths", 1) >= 1),
    "reviewed_order" INT NOT NULL,
    "reviewer" INT NOT NULL,
    "reviewed" INT NOT NULL,
    FOREIGN KEY ("reviewed_order") REFERENCES Orders("id") ON DELETE CASCADE,
    FOREIGN KEY ("reviewed") REFERENCES Users("id") ON DELETE CASCADE,
    FOREIGN KEY ("reviewer") REFERENCES Users("id") ON DELETE CASCADE
);

CREATE TABLE Admins(
    "id" SERIAL PRIMARY KEY NOT NULL,
    "email" TEXT UNIQUE NOT NULL,
    "profile_image_path" TEXT,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP ),
    "password" TEXT
);

CREATE TABLE Reports(
    "id" SERIAL PRIMARY KEY NOT NULL,
    "type" ReportType NOT NULL,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( "creation_date" <= CURRENT_TIMESTAMP ),
    "is_closed" BOOLEAN NOT NULL DEFAULT FALSE,
    "closed_by" INT,
    "reporter" INT,
    "reported" INT,
    "product" INT,
    "message" INT,
    FOREIGN KEY ("closed_by") REFERENCES Admins("id") ON DELETE SET NULL,
    FOREIGN KEY ("reporter") REFERENCES Users("id") ON DELETE SET NULL,
    FOREIGN KEY ("reported") REFERENCES Users("id") ON DELETE SET NULL,
    FOREIGN KEY ("product") REFERENCES Products("id") ON DELETE SET NULL,
    FOREIGN KEY ("message") REFERENCES Messages("id") ON DELETE SET NULL,
    CHECK ( ("type" = 'message' AND "message" IS NOT NULL) OR
            ("type" = 'user' AND "reported" IS NOT NULL) OR
            ("type" = 'product' AND "product" IS NOT NULL) )
);

CREATE TABLE Notifications(
    "id" SERIAL PRIMARY KEY,
    "creation_date" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "read" BOOLEAN NOT NULL DEFAULT FALSE,
    "dismissed" BOOLEAN NOT NULL DEFAULT FALSE,
    "type" NotificationType NOT NULL,
    "belongs_to" INT NOT NULL,
    "class_name" TEXT NOT NULL, -- we store the laravel class name in order to do automatic rendering of a notification
    "order_id" INT,
    "wishlist_product" INT,
    "cart_product" INT,
    "review" INT,
    "message" INT,
    "sold_product" INT,
    FOREIGN KEY ("belongs_to") REFERENCES Users("id") ON DELETE CASCADE,
    FOREIGN KEY ("order_id") REFERENCES Orders("id") ON DELETE CASCADE,
    FOREIGN KEY ("wishlist_product") REFERENCES Products("id"),
    FOREIGN KEY ("cart_product") REFERENCES Products("id"),
    FOREIGN KEY ("sold_product") REFERENCES Products("id"),
    FOREIGN KEY ("review") REFERENCES Reviews("id"),
    FOREIGN KEY ("message") REFERENCES  Messages("id"),
    CHECK ( ("type" = 'order_status' AND "order_id" IS NOT NULL) OR
            ("type" = 'wishlist' AND "wishlist_product" IS NOT NULL) OR
            ("type" = 'cart' AND "cart_product" IS NOT NULL) OR
            ("type" = 'review' AND "review" IS NOT NULL) OR
            ("type" = 'message' AND "message" IS NOT NULL) OR
            ("type" = 'sold' AND "sold_product" IS NOT NULL)
    )
);

CREATE TABLE ProductWishlist(
    "product" INT NOT NULL,
    "belongs_to" INT NOT NULL,
    PRIMARY KEY ("product", "belongs_to"),
    FOREIGN KEY ("product") REFERENCES Products("id") ON DELETE CASCADE,
    FOREIGN KEY ("belongs_to") REFERENCES Users("id") ON DELETE CASCADE
);

CREATE TABLE CartProduct(
    "product" INT NOT NULL,
    "belongs_to" INT NOT NULL,
    "applied_voucher" TEXT,
    PRIMARY KEY ("product", "belongs_to"),
    FOREIGN KEY ("product") REFERENCES Products("id") ON DELETE CASCADE,
    FOREIGN KEY ("belongs_to") REFERENCES Users("id") ON DELETE CASCADE,
    FOREIGN KEY ("applied_voucher") REFERENCES Vouchers("code") ON DELETE SET NULL
);

CREATE TABLE OrderProduct(
    "product" INT NOT NULL,
    "order_id" INT NOT NULL,
    "discount" NUMERIC NOT NULL DEFAULT 0 check ( "discount" >= 0 ),
    PRIMARY KEY ("product", "order_id"),
    FOREIGN KEY ("product") REFERENCES Products("id"),
    FOREIGN KEY ("order_id") REFERENCES Orders("id")
);

CREATE TABLE Payouts(
    "id" SERIAL PRIMARY KEY,
    "creation_date" DATE NOT NULL DEFAULT CURRENT_DATE CHECK ( "creation_date" <= CURRENT_DATE ),
    "tax" NUMERIC NOT NULL CHECK ( "tax" <= 1 AND "tax" >= 0 ),
    "paid_to" INT,
    FOREIGN KEY ("paid_to") REFERENCES Users("id") ON DELETE SET NULL
);

CREATE TABLE Jobs(
    "id" SERIAL PRIMARY KEY,
    "queue" TEXT NOT NULL,
    "payload" TEXT NOT NULL,
    "attempts" INT NOT NULL,
    "reserved_at" INT,
    "available_at" INT NOT NULL,
    "created_at" INT NOT NULL
);

CREATE TABLE "failed_jobs"(
    "id" SERIAL PRIMARY KEY,
    "uuid" TEXT UNIQUE NOT NULL,
    "connection" TEXT NOT NULL,
    "queue" TEXT NOT NULL,
    "payload" TEXT NOT NULL,
    "exception" TEXT NOT NULL,
    "failed_at" TIMESTAMP NOT NULL
);

-- INDICES

CREATE INDEX jobs_queue_index ON Jobs USING btree("queue");

CREATE INDEX notification_search_index ON Notifications USING hash(belongs_to);

CREATE INDEX product_wishlist_user_search_index ON ProductWishlist USING hash(belongs_to);

CREATE INDEX message_thread_search_index ON Messages USING btree(from_user, to_user, subject_product);

-- FTS

ALTER TABLE Products ADD COLUMN fts_search TSVECTOR;

CREATE OR REPLACE FUNCTION product_fts_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW."fts_search" = (
            setweight(to_tsvector('english', NEW.name), 'A') ||
            setweight(to_tsvector('english',
                        coalesce(string_agg((SELECT string_agg(a."value", ' ') FROM ProductAttributes pa JOIN Attributes a
                        ON a."id"=pa."attribute" WHERE pa."product"=NEW."id" GROUP BY pa."product"), ''), ' ')), 'B') ||
            setweight(to_tsvector('english', coalesce(NEW."description", '')), 'C')
            );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW."name" <> OLD."name" OR NEW."description" <> OLD."description") THEN
            NEW."fts_search" = (
                setweight(to_tsvector('english', NEW."name"), 'A') ||
                setweight(to_tsvector('english',
                        coalesce(string_agg((SELECT string_agg(a."value", ' ') FROM ProductAttributes pa JOIN Attributes a
                        ON a."id"=pa."attribute" WHERE pa."product"=NEW."id" GROUP BY pa."product"), ''), ' ')), 'B') ||
                setweight(to_tsvector('english', COALESCE(NEW."description", '')), 'C')
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
        setweight(to_tsvector('english', (SELECT "name" FROM Products where "id"=NEW."product")), 'A') ||
        setweight(to_tsvector('english',
                    coalesce((SELECT string_agg(a."value", ' ') FROM ProductAttributes pa JOIN Attributes a
                        ON a."id"=pa."attribute" WHERE pa."product"=NEW."product" GROUP BY pa."product"), '')), 'B') ||
        setweight(to_tsvector('english', coalesce((SELECT "description" FROM Products where "id"=NEW."product"), '')), 'C'))
        WHERE "id"=NEW."product";
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
   IF (SELECT "bargain_status" FROM Messages WHERE "id"=NEW."bargain_message") <> 'accepted' THEN
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
    IF (SELECT "belongs_to" FROM Vouchers WHERE "code"=NEW."applied_voucher") <> NEW."belongs_to" THEN
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
    IF (SELECT COUNT(*) FROM OrderProduct op JOIN Orders O on O."id" = op."order_id" WHERE O."status" <> 'cancelled'
                                                                                  AND op."product"=NEW."product") <> 0 THEN
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
    IF NEW."type" = 'wishlist' AND (SELECT COUNT(*) FROM ProductWishlist WHERE "product"=NEW."wishlist_product" AND "belongs_to"=NEW."belongs_to") <> 1 THEN
        RAISE EXCEPTION 'User doesnt have product in his wishlist...';
    END IF;
    IF NEW."type" = 'cart' AND (SELECT COUNT(*) FROM CartProduct WHERE "product"=NEW."cart_product" AND "belongs_to"=NEW."belongs_to") <> 1 THEN
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

    IF (SELECT "status" FROM Orders WHERE "id"=NEW."reviewed_order") <> 'received' THEN
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
    IF (SELECT COUNT(*) FROM OrderProduct WHERE "product"=NEW."subject_product") = 0 THEN
        RETURN NEW;
    END IF;
    IF (SELECT COUNT(*) FROM OrderProduct op JOIN Orders O on O."id" = op."order_id" WHERE op."product"=NEW."subject_product" AND O."status" <> 'cancelled') = 0 THEN
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
    IF (SELECT "price" FROM Products WHERE "id"=NEW."subject_product") <= NEW."proposed_price" THEN
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
    IF ((SELECT count(*) FROM ProductAttributes pa JOIN Attributes a ON a."id"=pa."attribute"
                         WHERE a."key"=(SELECT "key" FROM Attributes WHERE "id"=NEW."attribute") AND pa."product"=NEW."product") <> 0) THEN
        RAISE EXCEPTION 'You can only have one value per key in a product attribute';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS product_attribute_unique_validity ON ProductAttributes;
CREATE TRIGGER product_attribute_unique_validity BEFORE INSERT OR UPDATE ON ProductAttributes
    FOR EACH ROW EXECUTE PROCEDURE product_attribute_unique_key();
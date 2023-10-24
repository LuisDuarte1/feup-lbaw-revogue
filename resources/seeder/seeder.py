from faker import Faker
from datetime import datetime
import random
import uuid
import json
import math

fake = Faker()

product_world_list = ['sweat', 't-shirt', 'jeans', 'pants', 'skirts', 'red', 'blue', 'shoes', 'necklace', 'jacket', 'denim', 'shirt', 'shorts', 'pajamas', 'yellow', 'white'
                      'cute', 'fancy', 'goth', 'trendy', 'baby tea', 'vest', 'nike', 'adidas', 'retro', 'cargo', 'vintage']

order_statuses = ['pendingPayment', 'requestCancellation', 'pendingShippment', 'shipped', 'received']

settings = json.dumps({"settings": []})
users = []
file = open("populate.sql", "w")

file.write('SET search_path TO lbaw23107;\n\n')

attributes = [
    {"Size":"S"},
    {"Size":"M"},
    {"Size":"L"},
    {"Size":"XL"},
    {"Size":"XXL"},
    {"Size":"36"},
    {"Size":"38"},
    {"Size":"40"},
    {"Brand": "Zara"},
    {"Brand": "Adidas"},
    {"Brand": "Pull&Bear"},
    {"Brand": "Springfield"},
    {"Brand": "H&M"},
    {"Brand": "Nike"},
    {"Brand": "Bershka"},
    {"Brand": "Stradivarius"},
    {"Brand": "Primark"},
    {"Brand": "Shein"},
    {"Color": "Red"},
    {"Color": "Blue"},
    {"Color": "White"},
    {"Color": "Pink"},
    {"Color": "Orange"},
]

file.write("INSERT INTO Attributes(key, value) VALUES\n")
for i, attribute in enumerate(attributes):
    if i != len(attributes)-1:
        file.write(f"""\t('{list(attribute.keys())[0]}', '{list(attribute.values())[0]}'),\n""")
    else:
        file.write(f"""\t('{list(attribute.keys())[0]}', '{list(attribute.values())[0]}');\n""")
file.write("\n")

for a in range(50):
    user = fake.profile()
    user['database_id'] = a
    user["password"] = fake.password()
    user["bio"] = fake.text().replace('\n', '\\n')
    users.append(user)
file.write("""INSERT INTO Users (id, username, displayName, email, profileImagePath, bio, password, creationDate, settings, accountStatus) VALUES\n""")
for i in range(0, len(users)-1):
    file.write(f"""\t({users[i]['database_id']}, '{users[i]['username']}', '{users[i]['name']}', '{users[i]['mail']}', '{'/images/profiles/'+str(users[i]['database_id'])+'.png'}', '{users[i]['bio']}','{users[i]['password']}', '{datetime.utcnow().isoformat()}','{settings}', 'active'),\n""") 
file.write(f"""\t({users[-1]['database_id']}, '{users[-1]['username']}', '{users[-1]['name']}', '{users[-1]['mail']}', '{'/images/profiles/'+str(users[-1]['database_id'])+'.png'}', '{users[-1]['bio']}','{users[-1]['password']}', '{datetime.utcnow().isoformat()}','{settings}', 'active');\n""") 

# products

"""
CREATE TABLE Products(
    id TEXT PRIMARY KEY NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    name TEXT NOT NULL,
    description TEXT,
    price NUMERIC NOT NULL CHECK ( price >= 0 ),
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP CHECK ( creationDate <= CURRENT_TIMESTAMP ),
    imagePaths TEXT[] check ( array_length(imagePaths, 1) >= 1 )
);
"""
products = []
for p in range(50):
    pass
file.write('\n')
for i in range(0, len(users)-1):
    product = {}
    product['database_id'] = i
    product['slug'] = str(uuid.uuid4())
    product["name"] = fake.sentence(ext_word_list = product_world_list)
    product['description'] = fake.text().replace('\n', '\\n')
    product["price"] = round(random.uniform(0, 100),2)
    product['creationDate'] = datetime.utcnow().isoformat()
    product['soldBy'] = users[random.randrange(0, len(users))]['database_id']
    product['imagePaths'] = r'{"/images/products/product.png"}'
    products.append(product)


file.write("INSERT INTO Products (id, slug, name, description, price, creationDate, imagePaths, soldBy) VALUES\n")
for i in range(0, len(products)-1):
    file.write(f"\t({products[i]['database_id']}, '{products[i]['slug']}', '{products[i]['name']}', '{products[i]['description']}', {products[i]['price']}, '{products[i]['creationDate']}', '{products[i]['imagePaths']}', '{products[i]['soldBy']}'),\n")
file.write(f"\t({products[-1]['database_id']}, '{products[-1]['slug']}', '{products[-1]['name']}', '{products[-1]['description']}', {products[-1]['price']}, '{products[-1]['creationDate']}', '{products[-1]['imagePaths']}', '{products[-1]['soldBy']}');\n")
file.write('\n')

orders = []
products_suffle = products.copy()
random.shuffle(products_suffle)
for i in range(0, math.floor(len(products) / 10)):    
    num_products = random.randint(1, 5)
    order = {}
    order['products'] = []
    order['database_id'] = i
    order['creationDate'] = datetime.utcnow().isoformat()
    for e in range(0, num_products):
        order['products'].append(products_suffle.pop(0)['database_id'])
    order['orderStatus'] = order_statuses[random.randrange(0, len(order_statuses))]
    orders.append(order)

received_orders = filter(lambda x: x['orderStatus'] == "received", orders)

if(len(list(filter(lambda x: x['orderStatus'] == "received", orders))) == 0):
    print("No orders with received status, changing one order to be received....")
    orders[random.randrange(0, len(orders))]['orderStatus'] = 'received'
    received_orders = filter(lambda x: x['orderStatus'] == "received", orders)


file.write("INSERT INTO Orders (id, creationDate, status) VALUES\n")
for i in range(0, len(orders)-1):
    file.write(f"\t({orders[i]['database_id']}, '{orders[i]['creationDate']}', '{orders[i]['orderStatus']}'),\n")
file.write(f"\t({orders[-1]['database_id']}, '{orders[-1]['creationDate']}', '{orders[-1]['orderStatus']}');\n")
file.write('\n')

file.write("INSERT INTO OrderProduct (product, orderId, discount) VALUES\n")
for e,order in enumerate(orders):
    for i,product in enumerate(order['products']):
        discount = round(random.uniform(0,list(filter(lambda x: x['database_id'] == product, products))[0]['price']), 2)
        if(e != (len(orders) - 1) or i != (len(order['products']) - 1)):
            file.write(f"\t({product}, {order['database_id']}, {discount}),\n")
        else:
            file.write(f"\t({product}, {order['database_id']}, {discount});\n")
file.write('\n')

attributes_key_unique = list(set(map(lambda x: list(x.keys())[0], attributes)))
products_attributes = {}
for product in products:
    num_attributes = random.randrange(0, len(attributes_key_unique))
    attributes_key = attributes_key_unique.copy()
    random.shuffle(attributes_key)
    product_attrbutes = []
    for e,i in enumerate(attributes_key):
        if(e >= num_attributes):
            break
        kkkkk = list(filter(lambda x: list(x.keys())[0] == i, attributes))
        random.shuffle(kkkkk)
        product_attrbutes.append(kkkkk[0])
    if(len(product_attrbutes) == 0): continue
    products_attributes[product['database_id']] = product_attrbutes


file.write("INSERT INTO ProductAttributes (product, key, value) VALUES\n")
for e, pa in enumerate(products_attributes):
    for i, attrs in enumerate(products_attributes[pa]):
        if(e != (len(products_attributes) - 1) or i != (len(products_attributes[pa]) - 1)):
            file.write(f"\t({pa}, '{list(attrs.keys())[0]}', '{list(attrs.values())[0]}'),\n")
        else:
            file.write(f"\t({pa}, '{list(attrs.keys())[0]}', '{list(attrs.values())[0]}');\n")


file.write('\n')

file.write("INSERT INTO ProductWishlist (product, belongsTo) VALUES\n")
for i, user in enumerate(users):
    random.shuffle(products)
    wished_products_number = random.randint(1,10)
    for e, product in enumerate(products[:wished_products_number]):
        if(i != (len(users) - 1) or e != (wished_products_number - 1)):
            file.write(f"\t({product['database_id']}, {user['database_id']}),\n")
        else:
            file.write(f"\t({product['database_id']}, {user['database_id']});\n")


reviews = []


for i, order in enumerate(received_orders):
    review = {}
    review['database_id'] = i
    review['stars'] = float(random.randint(0, 10) / 2)
    review['description'] = fake.text().replace('\n', '\\n')
    review['reviewed'] = products[order['products'][0]]['soldBy']
    review['reviewer'] = None
    while(review['reviewer'] == None):
        random.shuffle(users)
        if(users[0]['database_id'] == review['reviewed']): continue
        review['reviewer'] = users[0]['database_id']
    review['reviewedOrder'] = order['database_id']
    reviews.append(review)

print(reviews)

file.close()
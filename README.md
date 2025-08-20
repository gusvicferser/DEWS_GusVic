# DAIA

My complete project, made entirely on __Laravel__ with __blade__ templates with it's own database made by me from scratch usign __mariadb__ and using __Bootstrap 4.0__ and __JavaScript__ vanilla on client's side. 

**DAIA** birth's reason is to offer the services of **__creating stories__** around a world based on the rules of Dungeons and DragonsTM that has its own rules, places, characters and objects, all in order to provide a way for the 
different authors to __share their creativity__ with other players of the popular tabletop role-playing game and with the perspective of reaching a commercial level that allows them to commit their full time to it. 
For that goal to happen, the web application has to fulfills certain functions to help the company achieve this objective. 

Among these functions are; to **__provide a platform for awareness__** and for the 
**__announcement of events__** created by the company, to **__offer both its adventures in booklets or PDFs and products of various kinds__** such as character figures or personalized dices, as well as 
illustrations and __the application has to allow users to create an account and follow events__ through notifications. 
The platform has to enable the **__creation of messages__** from users identified beforehand with an account to rate events and products they have purchased, creating feedback for other users. 

>[!IMPORTANT]
> **Key words**: creation, stories, adventures, world, characters, objects, platform, awareness, account, events, products, e-commerce, commentaries.

## UML Model

<img width="1920" height="1080" alt="UseCaseDiagramDAIA" src="https://github.com/user-attachments/assets/6d6a8e51-8f0a-459e-bef8-8ecd47f781e3" />

There are five main agents: **Guest**, **Player**, **Moderator**, **Administrator** and the own **System**. 

  + **Guest**: Can access the main page, browser events and products and also buy the last ones. 

  + **Player**: Can do the above but adding the fact that can subscribe to events and leave messages on both, products and events, apart from delete it's own account. 

  + **Moderator**: Can do the above and erase messages from products and events for moderation.

  + **Adminstrator**: Can create, edit and delete events and products, create and delete messages, change the status of a shipment, create an account, inhabilitate/delete an user and promote an user to moderator.

  + **System**: Can search products and create shipments.

## DAIA Database
<img width="1920" height="1080" alt="DAIA_DDBB" src="https://github.com/user-attachments/assets/e6b15dcd-8983-41b2-b3c6-0eb6118f9963" />

DAIA's database works with four entities; **User**, **Message**, **Product** and **Event**. Message has two especializations; __Review__ and __Comment__. 
__Reviews__ are the messages that are linked with Products and __Comments__ are the messages linked with Events. Once you erase a product, it erases its messages. Erasing events deletes also the reviews. Erasing an user deletes
its messages.

The relation between User and Product creates a table named Orders. The relation between User and Event creates a table name Subscriptions. 

## APIs {Server Side}

DAIA uses four APIs. **Events**, **Products**, **Login** and **Users** are managed from an API service. Here's a small fragment of them as a showcase:

  + Storage on Events:
<img width="655" height="469" alt="API_Event_Store" src="https://github.com/user-attachments/assets/c3e69c4f-276d-49be-8783-590452aa36b3" />

  + Login:
<img width="690" height="527" alt="API_Login" src="https://github.com/user-attachments/assets/987eafd3-ed78-49a1-8870-fedac980de8f" />

  + User inhabilitation:
<img width="494" height="431" alt="API_Inhabilitate" src="https://github.com/user-attachments/assets/1cbb5738-0d16-48df-8dde-37d077ee2d31" />

## API fetch {Client side}

+ Products:
<img width="572" height="1362" alt="API_fetch_JS_products" src="https://github.com/user-attachments/assets/ad3ce009-2866-4235-9390-0df2b9c0c5db" />


## SCREENSHOTS








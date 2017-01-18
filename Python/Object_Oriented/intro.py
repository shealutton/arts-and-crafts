#!/usr/bin/python

# Create the object class Character and 4 methods
class Character:

  # Method 1, __init__ is a special method to initialize a class
  def __init__(self, name, initial_health):
    self.name = name
    self.health = initial_health
    self.inventory = []

  # Method 2, another special method
  def __str__(self):
    s = "Name: " + self.name
    s += " Health: " + str(self.health)
    s += " Inventory: " + str(self.inventory)
    return s

  # Method 3 adds item to inventory
  def grab(self, item):
    self.inventory.append(item)

  # Method 4 is a health check
  def get_health(self):
    return self.health

# Interacting with the objects of class Character
def example():
  me = Character("Shea", 102)
  print str(me)
  me.grab("pencil")
  me.grab("paper")
  print str(me)
  print "Health:", me.get_health(), type(me)

example()
#help(Character)

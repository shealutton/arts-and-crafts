#! /usr/bin/python
# Shea Lutton, 2013 
# Attempt to validate the claim that the "Common Sense" trading strategy
# is better than a buy and hold strategy. Common Sense would dictate, sell 
# when stocks rise by x%, buy when stocks fall by x%, forcing buy low, sell high. 
# Buy and hold strategy can be determined by commenting out the Sell line.

# Best values I have found for "Buy and Hold"
# action_threshold = .05                                  # how much cash to buy or sell per transaction
# market_threshold = .05                                  # how much the market has to move to trigger an action
# Where cash = 30K, invest = 70K

import sys
from optparse import OptionParser

parser = OptionParser()
parser.add_option("-a", "--action", dest="action_threshold", type=float, help="% change in investments")
parser.add_option("-b", "--buy-multiplier", dest="buy_multiplier", type=int, help="Multiple of the action_threshold for aggressive buying")
parser.add_option("-m", "--market", dest="market_threshold", type=float, help="% change in market price")
(options, args) = parser.parse_args(args=None, values=None)

if options.action_threshold:
   action_threshold = options.action_threshold
else:
   print "missing -a (action_threshold), using .05"
   action_threshold = .05

if options.market_threshold:
   market_threshold = options.market_threshold
else:
   print "missing -m (market_threshold), using .05"
   market_threshold = .05

if options.buy_multiplier:
   buy_multiplier = options.buy_multiplier
else:
   print "missing -b (buy_multiplier), using 1"
   buy_multiplier = 1


#dates = open('graphable.dates.csv', 'w')

#f = open('/Users/shea/Dropbox/Source/Python/fin.analysis/SandP_daily_1950.txt', 'r')
#purchase = 16.66

#f = open('/Users/shea/Dropbox/Source/Python/fin.analysis/SandP_daily.1987.Before.txt', 'r')
#purchase = 333.33

#f = open('/Users/shea/Dropbox/Source/Python/fin.analysis/SandP_daily.1987.After.txt', 'r')
#purchase = 224.84

f = open('/Users/shea/Dropbox/Source/Python/fin.analysis/SandP_daily.txt', 'r')
purchase = 1268.8

#f = open('/Users/shea/Dropbox/Source/Python/fin.analysis/SandP_daily.txt.FAKE', 'r')
#purchase = 10

header = f.readline() 					# first line describes the file
body = f.readlines() 					# remaining lines are data rows
cash = 3000						# cash on hand at day 0
invest = 7000						# how much is invested on day 0
shares = float(invest / purchase)			# initial shares owned
tax_paid = 0						# initial taxes paid
ltcg = .15						# long term capital gains rate
history = [[shares, purchase]]				# transaction log
graphable_date = 0

def taxes(s, p):					# current shares and price, shares must be negative, indicating a sale
  global history
  s = float(s)
  p = float(p)
  capital = 0
  value = s * p
  while not ( s == 0 ):
    temp = history[0]
    if ( temp[0] >= abs(s) ):				# Remaining shares are less than the oldest purchase amount
      capital += ( s * temp[1] )			# historical price of remaining shares
      history[0][0] = temp[0] + s			# subtract the outstanding shares from the historical purchase
      s = 0
    else:						# Remaining shares are greater than the oldest purchase amount
      capital += ( temp[0] * temp[1] )			# historical shares * price = cost
      s += temp[0]
      history.pop(0)
  gain = value - capital
  tax = ( ltcg * gain )
  #print "Shares\t", value/p, "Price\t", p, "Value\t", value, "Capital\t", capital, "Gain\t", gain, "Tax\t", tax 
  if tax > 0:						# Tax > 0 would indicate IRS pays you. Ain't gunna happen. 
    tax = 0
  return tax


def transaction(sign, price):
  global shares, cash, tax_paid
  sign = int(sign)
  if sign == 1:						# 1 = BUY
    action_value = sign * buy_multiplier * action_threshold * cash	# Calculate the purchase amount
    if ( action_value > cash ):				# Protection to not run out of cash
      action_value = cash
  elif sign == -1:					# -1 = SELL
    action_value = sign * action_threshold * shares * price	# Calculate the sale amount
  else:
    print "Error!"    
  shares_in_transaction = action_value / price 		# calculate the number of shares to buy/sell
  if sign == 1:						# 1 = BUY
    tax_due = 0						# no tax on a purchase
    cash -= ( action_value )				# reduce cash by the price
    history.append([shares_in_transaction, price])	# add purchase to transaction log
  elif sign == -1:					# -1 = SELL
    tax_due = taxes(shares_in_transaction, price)	# calculate taxes
    #tax_due = 0					# simulate tax free/deferred accounts (Roth, 401k)
    cash -= ( action_value - tax_due )			# increase cash by adding the negative number

  tax_paid += tax_due
  shares += shares_in_transaction
  return shares_in_transaction, action_value, tax_due

sell_record = []
buy_record = []

for i in body:						# Read through historical prices
  date, price = i.split(' ')
  price = float(price.rstrip())
  graphable_date += 1
  #if ( (graphable_date % 5) == 0 ) and ( (graphable_date % 600) == 0):
  #  print graphable_date, ",", round(cash + shares * price, 2), ",", date
  #elif ( (graphable_date % 5) == 0 ):
  #  print graphable_date, ",", round(cash + shares * price, 2), ",cash,", cash, ",shares,", shares, ",price,", price 
  #  text = '%s, %s, %s\n' %(graphable_date, price, date)
  #  dates.write(text)
  if price >= purchase + ( purchase * market_threshold ) and ( shares > 0 ):	# if today's price is high, SELL
    ### FOR BUY AND HOLD, COMMENT OUT THE NEXT TWO LINES
    s, a, t = transaction(-1, price)
    #print "SEL\t ", date, graphable_date, "\t", price, "  \t", shares, "\t", s, a, t, "\tcash\t", cash, "\ttotal\t", shares * price + cash
    #print "SEL\t ", graphable_date, ",", shares * price + cash, ",", date
    #sell_record.append(["SEL", graphable_date, price, shares, t, "Invested", shares * price, "Total", shares * price + cash])
    ###
    purchase = float(price)				# Set the purchase equal to today's price
  elif price <= purchase - ( purchase * market_threshold ):	# if today's price is low, buy
   if cash > 100:					# Eliminate small rounding purchases
    s, a, t = transaction(1, price)			
    #print "BUY\t ", date, graphable_date, "\t", price, "  \t", shares, s, a, t, "\t\t\tcash\t", cash, "\ttotal\t", shares * price + cash
    #print "BUY\t ", graphable_date, ",", shares * price + cash, ",", date
    #print "BUY\t ", date, "\t", price, "  \t", s, "\ttotal\t", shares * price + cash
    #buy_record.append(["BUY", graphable_date, price, s, price, "Invested", shares * price, "Total", shares * price + cash])
    purchase = float(price)				# Set the purchase equal to today's price

print "\t", round(cash + shares * price, 2), "\tTaxes: ", round(tax_paid, 2), "Shares ", round(shares, 3), "Cash ", round(cash, 2), shares * price, price
### Debug and sanity check
#for i in sell_record:
#  print i
#for i in buy_record:
#  #print i[3], "  \t", i[4]
#  print i
